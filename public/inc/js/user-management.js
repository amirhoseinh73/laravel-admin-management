class UserManagement {

    static documentReadyFunction = async () => {
        const userManagement = new UserManagement();

        await userManagement.listUser();

    }

    listUser = async () => {
        const data = {
            data    : {},
            method  : "GET",
        };

        let routeListUser = Routes.userList
        if ( typeof is_user_registered_by_admin !=="undefined" && is_user_registered_by_admin ) routeListUser = Routes.userListRegisteredByAdmin

        await ajaxFetch( routeListUser, this.listUserHandler, data );
    }

    listUserHandler = ( respond ) => {
        const table_selector = document.getElementById( "user_management_table" ).querySelector( "tbody" );

        if ( respond.status !== "success" ) {
            sweetAlert( respond );
            return;
        }

        table_selector.innerHTML = "";
        respond.data.forEach( ( data, index ) => {
            table_selector.insertAdjacentHTML( "beforeend",
            `<tr data-id="${ data.id }">
                <td>${ index + 1 }</td>
                <td data-key="firstname" data-type="text">${ data.firstname }</td>
                <td data-key="lastname" data-type="text">${ data.lastname }</td>
                <td data-key="username" data-type="text" data-input-type="number">${ data.username }</td>
                <td data-key="mobile" data-type="text" data-input-type="number">${ data.mobile }</td>
                <td data-key="grade" data-type="select" data-select="اول,دوم,سوم,چهارم,پنجم,ششم" data-select-value="1,2,3,4,5,6" data-select-current="${ data.grade }" data-multiple="true">${ this.getGrade( data.grade ) }</td>
                <td data-key="gender" data-type="select" data-select="آقا,خانم" data-select-value="1,2" data-select-current="${ data.gender }">${ this.getGender( data.gender ) }</td>
                <td data-key="status" data-type="select" data-select="فعال,غیرفعال,مسدود" data-select-value="1,2,3" data-select-current="${ data.status }">${ this.getStatus( data.status ) }</td>
                <td data-key="created_at">${ data.created_at }</td>
                <td data-key="expired_at" data-type="datetime">${ data.expired_at }</td>
                <td data-key="last_login_at">${ data.last_login_at }</td>
                <td data-key="recovered_password_at">${ data.recovered_password_at }</td>
                <td>
                    <button type="button" class="btn btn-danger waves-effect waves-light fas fa-times btn-remove-data"></button>
                    <button type="button" class="btn btn-warning waves-effect waves-light fas fa-key btn-reset-password"></button>
                </td>
            </tr>` );
        } );

        this.itemDataHandler();
        loadDataTable( "user_management_table" )
    }

    getStatus = ( index ) => {
        const status = {
            "1": "<span class='badge badge-success'>فعال</span>",
            "2": "<span class='badge badge-danger'>غیرفعال</span>",
            "3": "<span class='badge badge-warning'>مسدود شده</span>",
        };

        return status[ index ]
    }

    getGender = ( index ) => {
        const gender = {
            "1": "<span class='badge badge-info'>آقا</span>",
            "2": "<span class='badge badge-primary'>خانم</span>",
        };

        return gender[ index ]
    }

    getGrade = ( grade ) => {
        if ( ! grade ) return "";
        const gradeSplitted = grade.split( "," );
        let gradeText = "";

        gradeSplitted.forEach( ( item, index ) => {
            gradeText += this.gradeHandler[ item ] + "<br/>"
        } )

        return gradeText
    }

    get gradeHandler() {
        return {
            1: "اول",
            2: "دوم",
            3: "سوم",
            4: "چهارم",
            5: "پنجم",
            6: "ششم",
        }
    }

    itemDataHandler() {

        this.dataRemoveHandler();

        this.dataTypeTextHandler();
        this.dataTypeSelectHandler();

        this.resetPasswordHandler()

        this.dataDatetimeHandler()
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
                this.resetPasswordHandlerEvent.call( this, button );
            } );
        } );
    }

    resetPasswordHandlerEvent( button ) {
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

    dataDatetimeHandler = () => {
        const data = document.querySelectorAll( "[data-type='datetime']" );

        data.forEach( datum => {
            datum.addEventListener( "click", ( e ) => {
                const td = e.target;
                if ( td.tagName.toUpperCase() === "INPUT" ) return ;
                this.dataDatetimeHandlerEvent.call( this, td.closest( "td" ) );
            } );
        } );
    }

    dataDatetimeHandlerEvent = ( td ) => {

        const id = td.closest( "[data-id]" ).getAttribute( "data-id" );

        const save = () => {
            const value = td.querySelector( "input" ).value.trim();

            td.innerHTML = "";
            td.insertAdjacentHTML( "afterbegin", `${ value }` );
            
            td.classList.remove( "active" );
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
        console.log(text);

        td.innerHTML = "";
        td.classList.add( "active" );

        const createInput = document.createElement( "input" )
        createInput.type = "text"
        const classes = [ "form-control", "form-control-sm", "input-enter-save" ]
        createInput.classList.add( ...classes )
        createInput.value = text
        createInput.id = "datetime" + id

        createInput.style.minWidth = "10rem"
        td.insertAdjacentElement( "afterbegin", createInput );

        td.offsetLeft

        callCalendar( "datetime" + id, text )
        
        return eventKeyUpEnterHandler( save );
    }

}

function eventKeyUpEnterHandler( callback ) {
    document.querySelector( ".input-enter-save" ).addEventListener( "keyup", ( e ) => {

        if ( e.which !== 13 ) return;

        callback();
    } );
}

docReady( UserManagement.documentReadyFunction );