const Routes = {
    url: url,
    login: url + "/login",
    dashboard: url + "/dashboard",
    
    generateCode: url + "/dashboard/generate-activation-code/api/generate-code",
    listCode: url + "/dashboard/generate-activation-code/api/list-code",
    
    offlinePageFormSubmit: url + "/api/offline/activation/generate-code-page",
    recaptcha: url + "/api/offline/activation/recaptcha",

    discountCodeCreate: url + '/dashboard/discount-code/create',
    discountCodeLoad: url + '/dashboard/discount-code/load',
    discountCodeRemove: url + '/dashboard/discount-code/remove',
}