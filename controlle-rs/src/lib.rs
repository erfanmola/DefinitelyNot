use std::ffi::{c_char, CStr, CString};

#[derive(sonic_rs::Serialize, sonic_rs::Deserialize, Debug)]
struct Asset {
    contract_address: String,
    symbol: String,
    display_name: String,
    decimals: Option<i32>,
    kind: String,
    deprecated: bool,
    community: bool,
    blacklisted: bool,
    default_symbol: bool,
    dex_usd_price: Option<String>,
    dex_price_usd: Option<String>,
}

#[derive(sonic_rs::Deserialize)]
struct ApiResponse {
    asset_list: Vec<Asset>,
}

#[no_mangle]
pub unsafe extern "C" fn fetch_stonfi_assets_filtered(contracts_ptr: *const c_char) -> *mut c_char {
    let res = internal_fetch_stonfi_assets_filtered(contracts_ptr).unwrap_or(CString::default());
    res.into_raw()
}

#[no_mangle]
unsafe fn internal_fetch_stonfi_assets_filtered(
    contracts_ptr: *const c_char,
) -> Result<CString, ()> {
    let contracts_str = unsafe { CStr::from_ptr(contracts_ptr).to_str().unwrap_or("") };
    let contracts = contracts_str.split(',').collect::<Vec<_>>();

    let response: String = ureq::get("https://api.ston.fi/v1/assets")
        .call()
        .map_err(|_| ())?
        .body_mut()
        .read_to_string()
        .map_err(|_| ())?;

    let json: ApiResponse = sonic_rs::from_str(&response).map_err(|_| ())?;

    let filtered = json
        .asset_list
        .iter()
        .filter(|item| contracts.contains(&item.contract_address.as_str()))
        .collect::<Vec<_>>();

    let result_json = sonic_rs::to_string(&filtered).map_err(|_| ())?;

    CString::new(result_json).map_err(|_| ())
}
