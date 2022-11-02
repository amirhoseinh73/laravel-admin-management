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
                <td data-key="firstname" data-type="text">${ data.grade }</td>
                <td data-key="lastname" data-type="text">${ data.windows_code }</td>
                <td data-key="username" data-type="text" data-input-type="number">${ data.user_code || "" }</td>
                <td data-key="mobile" data-type="text" data-input-type="number">${ data.generated_code || "" }</td>
                <td data-key="grade" >${ this.getUsedTimes( data.limit_usage ) }</td>
                <td data-key="created_at">${ this.handleMobileData( data.mobile ) }</td>
                <td data-key="last_login_at">${ this.getIsForShoppingSite[ +data.is_for_shopping_site ] }</td>
                <td data-key="recovered_password_at">${ data.order_id || "" }</td>
                <td data-key="recovered_password_at">${ this.getIsDeleted( data.deleted_at ) }</td>
                <td>
                    <button type="button" class="btn btn-danger waves-effect waves-light fas fa-times btn-remove-data"></button>
                </td>
            </tr>` );
        } );

        // this.itemDataHandler();
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
        this.dataTypeSelectHandler();

        this.resetPasswordHandler()
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

            ajaxFetch( Routes.manageUserRemoveItem, this.dataRemoveHandlerEventSuccess.bind( button ), data );
        } );
    }

    dataRemoveHandlerEventSuccess( respond ) {
        if ( respond.status !== "success" ) {
            sweetAlert( respond );
            return;
        }
        sweetAlert( respond );
        this.closest( "tr" ).remove();
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

            ajaxFetch( Routes.manageUserUpdateItem, sweetAlert, data );
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

    dataTypeSelectHandler = () => {
        const selectInputs = document.querySelectorAll( "[data-type='select']" );

        selectInputs.forEach( select => {
            select.addEventListener( "click", ( e ) => {
                const td = e.target;
                if ( td.tagName.toUpperCase() === "SELECT" || td.tagName.toUpperCase() === "OPTION" ) return ;
                this.dataTypeSelectHandlerEvent.call( this, td.closest( "td" ) );
            } );
        } );
    }

    dataTypeSelectHandlerEvent = async ( td ) => {

        const save = () => {
            const select_box = td.querySelector( "select" );

            const select_value_in_array = getSelectValues( select_box ).join( "," );
            // const select_text = select_box.options[select_box.selectedIndex].text;
            const key = td.dataset.key
            const functionName = "get" + key[ 0 ].toUpperCase() + key.substring( 1 )

            const callFunctionName = {
                "getGrade": this.getGrade,
                "getGender": this.getGender,
                "getStatus": this.getStatus,
            }

            td.innerHTML = "";
            td.insertAdjacentHTML( "afterbegin", `${ callFunctionName[functionName]( select_value_in_array ) }` );
            td.setAttribute( "data-select-current", select_value_in_array );
            
            td.classList.remove( "active" );
            
            const ID = td.closest( "[data-id]" ).getAttribute( "data-id" );

            const data = {
                data    : {
                    id: ID,
                    key: key,
                    data: select_value_in_array,
                },
                method : "POST",
            };

            ajaxFetch( Routes.manageUserUpdateItem, sweetAlert, data );
        }

        if ( td.classList.contains( "active" ) ) return save()

        const selectOptions = td.dataset.select.split( "," )
        const selectOptionValues = td.dataset.selectValue.split( "," )

        if ( ! selectOptionValues || ! selectOptions ) return

        const loadOptions = ( currentSelected ) => {
            return selectOptions.map( ( option, index ) => {
                const value = selectOptionValues[ index ]

                return `<option value="${ value }" ${ ( currentSelected.includes( value ) ) ? "selected" : "" }>${ option }</option>`;
            } ).join( "\n" );
        }

        const isMultiple = !!td.dataset.multiple
        const currentSelected = td.dataset.selectCurrent.split( "," );

        const createSelect = document.createElement( "select" )
        const classes = [ "custom-select", "custom-select-sm", "input-enter-save" ]
        createSelect.classList.add( ...classes )
        createSelect.value = currentSelected[ 0 ]
        if( isMultiple ) {
            createSelect.multiple = "true"
            createSelect.value = currentSelected
        }
        createSelect.insertAdjacentHTML( "beforeend", loadOptions( currentSelected ) )
        createSelect.style.minWidth = "10rem"

        td.innerHTML = "";
        td.insertAdjacentElement( "afterbegin", createSelect )
        td.classList.add( "active" );
        
        return eventKeyUpEnterHandler( save );
    }

    resetPasswordHandler() {
        const buttons = document.querySelectorAll( ".btn-reset-password" );

        buttons.forEach( button => {
            button.addEventListener( "click", ( e ) => {
                const button = e.target.closest( ".btn-reset-password" );
                if ( ! button ) return console.error( "button not found" );
                this.resetPasswordHandlerEvemt.call( this, button );
            } );
        } );
    }

    resetPasswordHandlerEvemt( button ) {
        sweetAlertConfirm( () => {
            const id = button.closest( "[data-id]" ).getAttribute( "data-id" );

            const data = {
                data    : {
                    id: id,
                },
                method  : "POST",
            };

            ajaxFetch( Routes.manageUserResetPassword, sweetAlert, data );
        } );
    }

}

function eventKeyUpEnterHandler( callback ) {
    document.querySelector( ".input-enter-save" ).addEventListener( "keyup", ( e ) => {

        if ( e.which !== 13 ) return;

        callback();
    } );
}

docReady( OfflineCodeManagement.documentReadyFunction );