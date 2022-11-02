const Routes = {
    url: url,
    login: url + "/login",
    dashboard: url + "/dashboard",
    
    discountCodeCreate: url + '/dashboard/discount-code/create',
    discountCodeLoad: url + '/dashboard/discount-code/load',
    discountCodeRemove: url + '/dashboard/discount-code/remove',

    manageContentsListGrade  : url + "/dashboard/manage-book-content/list-grade",
    manageContentsListBook   : url + "/dashboard/manage-book-content/list-book",
    manageContentsListConetnt: url + "/dashboard/manage-book-content/list-content",
    manageContentsListAllBooks: url + "/dashboard/manage-book-content/list-all-book",
    manageContentsRemoveItem : url + "/dashboard/manage-book-content/content-remove",
    manageContentsUpdateItem : url + "/dashboard/manage-book-content/content-update",

    generateCode: url + "/dashboard/generate-activation-code/api/generate-code",
    listCode: url + "/dashboard/generate-activation-code/api/list-code",
    
    offlinePageFormSubmit: url + "/api/offline/activation/generate-code-page",
    recaptcha: url + "/api/offline/activation/recaptcha",

    //users
    userList: url + "/dashboard/user/management/list",
    manageUserRemoveItem: url + "/dashboard/user/management/remove",
    manageUserUpdateItem: url + "/dashboard/user/management/update",
    manageUserResetPassword: url + "/dashboard/user/management/reset-password",
    manageUserRegister: url + "/dashboard/user/management/register",

    //offline
    offlineCodeList: url + "/dashboard/offline/management/list",
    offlineCodeRemove: url + "/dashboard/offline/management/remove",
    offlineCodeUpdate: url + "/dashboard/offline/management/update",
}