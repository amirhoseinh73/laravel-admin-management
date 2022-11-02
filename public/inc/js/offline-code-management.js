class OfflineCodeManagement {

    static documentReadyFunction = async () => {
        const offlineCodeManagement = new OfflineCodeManagement();

        await offlineCodeManagement.lisCode();

    }

    lisCode = async () => {
        const data = {
            data    : {},
            method  : "GET",
        };

        await ajaxFetch( Routes.offlineCodeList, this.lisCodeHandler, data );
    }

    lisCodeHandler = ( respond ) => {
        const table_selector = document.getElementById( "offline_code_management_table" ).querySelector( "tbody" );

        if ( respond.status !== "success" ) {
            sweetAlert( respond );
            return;
        }

        table_selector.innerHTML = "";
        respond.data.forEach( ( data, index ) => {
            table_selector.insertAdjacentHTML( "beforeend",
            `<tr data-id="${ data.id }">
                <td>${ index + 1 }</td>
                <td data-key="grade">${ data.grade }</td>
                <td data-key="windows_code">${ data.windows_code }</td>
                <td data-key="user_code">${ data.user_code || "" }</td>
                <td data-key="generated_code">${ data.generated_code || "" }</td>
                <td data-key="used_times">${ this.getUsedTimes( data.limit_usage ) }</td>
                <td data-key="limit_usage" data-type="text" data-input-type="number">${ +data.limit_usage }</td>
                <td data-key="mobile">${ this.handleMobileData( data.mobile ) }</td>
                <td data-key="is_for_shopping_site">${ this.getIsForShoppingSite[ +data.is_for_shopping_site ] }</td>
                <td data-key="order_id">${ data.order_id || "" }</td>
                <td data-key="deleted_at">${ this.getIsDeleted( data.deleted_at ) }</td>
                <td>
                    <button type="button" class="btn btn-danger waves-effect waves-light fas fa-times btn-remove-data" ${ ( data.deleted_at !== null && "disabled" ) }></button>
                </td>
            </tr>` );
        } );

        this.itemDataHandler();
        loadDataTable( "offline_code_management_table" )
    }

    get getIsForShoppingSite() {
        return {
            0: "<span class='badge badge-info'>خیر</span>",
            1: "<span class='badge badge-success'>بلی</span>",
        }
    }

    getUsedTimes = ( limit ) => {
        return 3 - ( +limit )
    }

    getIsDeleted( deleted_at ) {
        if ( deleted_at === null ) return "<span class='badge badge-info'>خیر</span>"

        return "<span class='badge badge-warning'>بلی</span>"
    }

    handleMobileData = ( mobile ) => {
        if ( ! mobile ) return ""
        let returnHTML = `<ol>`
        if ( mobile instanceof Array ) {
            mobile.forEach( data => {
                if ( data instanceof Object ) {
                    returnHTML += `<li><ul class="mb-4">`
                    for( const key in data ) {
                        returnHTML += `
                        <li>${ key } -> ${ data[ key ] }</li>
                        `
                    }
                    returnHTML += `</ul></li>`
                } else {
                    returnHTML += `
                        <li>موبایل -> ${ data }</li>
                    `
                }
            } )
        } else {
            returnHTML += `
                <li>موبایل -> ${ mobile }</li>
            `
        }

        returnHTML += "</ol>"

        return returnHTML
    }

    itemDataHandler() {

        this.dataRemoveHandler();

        this.dataTypeTextHandler();
    }

    dataRemoveHandler() {
        const buttons = document.querySelectorAll( ".btn-remove-data" );

        buttons.forEach( button => {
            button.addEventListener( "click", ( e ) => {
                const button = e.target.closest( ".btn-remove-data" );
                if ( ! button ) return console.error( "button not found" );
                this.dataRemoveHandlerEvent.call( this, button );
            } );
        } );
    }

    dataRemoveHandlerEvent( button ) {
        sweetAlertConfirm( () => {
            const id = button.closest( "[data-id]" ).getAttribute( "data-id" );

            const data = {
                data    : {
                    id: id,
                },
                method  : "POST",
            };

            ajaxFetch( Routes.offlineCodeRemove, this.dataRemoveHandlerEventSuccess.bind( button ), data );
        } );
    }

    dataRemoveHandlerEventSuccess( respond ) {
        if ( respond.status !== "success" ) {
            sweetAlert( respond );
            return;
        }
        sweetAlert( respond );
        this.closest( "tr" ).querySelector( "[data-key='deleted_at']" ).innerHTML = "<span class='badge badge-warning'>بلی</span>";
        this.closest( "tr" ).querySelector( ".btn-remove-data" ).setAttribute( "disabled", "true" );
    }

    dataTypeTextHandler = () => {
        const data = document.querySelectorAll( "[data-type='text']" );

        data.forEach( datum => {
            datum.addEventListener( "click", ( e ) => {
                const td = e.target;
                if ( td.tagName.toUpperCase() === "INPUT" ) return ;
                this.dataTypeTextHandlerEvent.call( this, td.closest( "td" ) );
            } );
        } );
    }

    dataTypeTextHandlerEvent = ( td ) => {

        const save = () => {
            const value = td.querySelector( "input" ).value.trim();

            td.innerHTML = "";
            td.insertAdjacentHTML( "afterbegin", `${ value }` );
            
            td.classList.remove( "active" );
            const id = td.closest( "[data-id]" ).getAttribute( "data-id" );
            const key = td.dataset.key

            const data = {
                data    : {
                    id: id,
                    data: value,
                    key: key,
                },
                method  : "POST",
            };

            ajaxFetch( Routes.offlineCodeUpdate, sweetAlert, data );
        }

        if ( td.classList.contains( "active" ) ) return save();

        const text = td.innerHTML.trim();

        td.innerHTML = "";
        td.classList.add( "active" );

        const createInput = document.createElement( "input" )
        createInput.type = "text"
        const classes = [ "form-control", "form-control-sm", "input-enter-save" ]
        createInput.classList.add( ...classes )
        createInput.value = text

        for (let i = 0, atts = td.attributes, n = atts.length, arr = []; i < n; i++) {
            const attrKey = atts[ i ].nodeName;
            const attrValue = atts[ i ].nodeValue;

            if ( ! attrKey.includes( "data-" ) ) continue

            createInput.setAttribute( attrKey, attrValue )
        }
        createInput.style.minWidth = "10rem"
        td.insertAdjacentElement( "afterbegin", createInput );

        td.offsetLeft
        input_text_number()
        
        return eventKeyUpEnterHandler( save );
    }

}

function eventKeyUpEnterHandler( callback ) {
    document.querySelector( ".input-enter-save" ).addEventListener( "keyup", ( e ) => {

        if ( e.which !== 13 ) return;

        callback();
    } );
}

docReady( OfflineCodeManagement.documentReadyFunction );