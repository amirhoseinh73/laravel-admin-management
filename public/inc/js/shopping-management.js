class ShoppingManagement {

    static documentReadyFunction = async () => {
        const shoppingManagement = new ShoppingManagement();

        await shoppingManagement.list();

    }

    list = async () => {
        const data = {
            data    : {},
            method  : "GET",
        };

        await ajaxFetch( Routes.shoppingListOrders, this.listUserHandler, data );
    }

    listUserHandler = ( respond ) => {
        const table_selector = document.getElementById( "shopping_list_orders" ).querySelector( "tbody" );

        if ( respond.status !== "success" ) {
            sweetAlert( respond );
            return;
        }

        table_selector.innerHTML = "";
        respond.data.forEach( ( data, index ) => {
            console.log(data.productList);
            table_selector.insertAdjacentHTML( "beforeend",
            `<tr data-id="${ data.id }">
                <td>${ index + 1 }</td>
                <td data-key="firstname">${ data.firstname }</td>
                <td data-key="lastname">${ data.lastname }</td>
                <td data-key="username">${ data.username }</td>
                <td data-key="mobile">${ data.mobile }</td>
                <td data-key="amount">${ data.amount }</td>
                <td data-key="amount_discounted">${ data.amount_discounted }</td>
                <td data-key="order_id"># ${ data.order_id }</td>
                <td data-key="productList"><ol>${ data.productList.map( product => `<li>${ product }</li>` ).join( "" ) }</ol></td>
                <td data-key="address">${ data.address }</td>
                <td data-key="address">${ data.post_code }</td>
                <td data-key="res_num">${ data.res_num }</td>
                <td data-key="created_at">${ data.created_at }</td>
            </tr>` );
        } );

        loadDataTable( "shopping_list_orders" )
    }
}

docReady( ShoppingManagement.documentReadyFunction );