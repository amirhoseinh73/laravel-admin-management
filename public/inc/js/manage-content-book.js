class ManageContentBook {

    state = {
        list_grade_url  : base_url + "/dashboard/manage-book-content/list-grade",
        list_book_url   : base_url + "/dashboard/manage-book-content/list-book",
        list_conetnt_url: base_url + "/dashboard/manage-book-content/list-content",

        item_content_remove : base_url + "/dashboard/manage-book-content/content-remove",
        item_content_update : base_url + "/dashboard/manage-book-content/content-update",

        offset  : 0,
        limit   : 20,

        list_all_books: [],
        list_all_books_url: base_url + "/dashboard/manage-book-content/list-all-book",
    };

    static async documentReadyFunction() {
        const manage_content_book = new ManageContentBook();

        await manage_content_book.listGrade();

        manage_content_book.listBook();
    }

    async listGrade() {

        const data = {
            data    : {},
            method  : "GET",
        };

        await ajaxFetch( this.state.list_grade_url, this.listGradeHandler, data );
    }

    listGradeHandler( respond ) {
        const grade_selector = document.getElementById( "list_grade" );

        if ( respond.status !== "success" ) {
            sweetAlert( respond );
            return;
        }

        grade_selector.insertAdjacentHTML( "beforeend", `<option value="none" selected>انتخاب کنید</option>` );
        
        for ( const [ grade_id, grade_title ] of Object.entries( respond.data ) ) {
            grade_selector.insertAdjacentHTML( "beforeend", `<option value='${grade_id}'>${grade_title}</option>` );
        }
    }

    listBook() {

        const grade_selector = document.getElementById( "list_grade" );

        grade_selector.addEventListener( "change", ( e ) => {
            const data = {
                data    : {
                    grade_id: e.target.closest( "select" ).value,
                },
                method  : "GET",
            };

            ajaxFetch( this.state.list_book_url + "?grade_id=" + data.data.grade_id, this.listBookHandler.bind( this ), data );
        } );
        
    }

    listBookHandler( respond ) {
        const book_html_id = document.getElementById( "list_book" );
        const table_selector = document.getElementById( "manage_content_table" ).querySelector( "tbody" );

        if ( respond.status !== "success" ) {
            sweetAlert( respond );
            return;
        }

        table_selector.innerHTML = "";
        book_html_id.innerHTML = "";
        book_html_id.insertAdjacentHTML( "beforeend", `<option value="none" selected>انتخاب کنید</option>` );
        respond.data.forEach( book => {
            book_html_id.insertAdjacentHTML( "beforeend", `<option value='${book.id}'>${book.title}</option>` );
        } );

        this.listContent();
    }

    listContent() {

        const book_html_id = document.getElementById( "list_book" );

        book_html_id.addEventListener( "change", ( e ) => {
            
            const data = {
                data    : {
                    book_id: e.target.closest( "select" ).value,
                },
                method  : "GET",
            };

            ajaxFetch( this.state.list_conetnt_url + "?book_id=" + data.data.book_id, this.listContentHandler.bind( this ), data );
        } );
        
    }

    listContentHandler( respond ) {
        const table_selector = document.getElementById( "manage_content_table" ).querySelector( "tbody" );

        if ( respond.status !== "success" ) {
            sweetAlert( respond );
            return;
        }

        const click = "کلیک!";
        table_selector.innerHTML = "";
        respond.data.forEach( ( content, index ) => {
            table_selector.insertAdjacentHTML( "beforeend",
            `<tr data-id="${ content.id }">
                <td>${ index + 1 }</td>
                <td>${ this.mediaType[ content.type ] }</td>
                <td class="book-title-handler" data-book-id="${ content.book_id }">${ content.book_title }</td>
                <td class="page-handler">${ content.page }</td>
                <td class="title-handler">${ content.title }</td>
                <td class="description-handler">${ content.description }</td>
                <td class="publisher-handler">${ content.publisher }</td>
                <td class="width-handler">${ content.width }</td>
                <td class="height-handler">${ content.height }</td>
                <td class="status-handler">${ this.status[ content.status ] }</td>
                <td><a target="_blank" href="${ content.url }">${click}</a></td>
                <td><button type="button" class="btn btn-danger waves-effect waves-light fas fa-times btn-remove-content"></button></td>
            </tr>` );
        } );

        this.itemContentHandler();
    }

    itemContentHandler() {

        this.contentRemoveHandler();

        this.contentPageHandler();
        this.contentStatusHandler();

        this.contentUpdateColumnHandler( "title" );
        this.contentUpdateColumnHandler( "description" );
        this.contentUpdateColumnHandler( "publisher" );
        this.contentUpdateColumnHandler( "width" );
        this.contentUpdateColumnHandler( "height" );

        this.contentBookIdHandler();
    }

    get mediaType() {
        return {
            "1": "فیلم",
            "2": "صدا",
            "3": "تصویر",
            "4": "محتوای تعاملی",
        };
    }

    get status() {
        return {
            0: "<span class='badge badge-danger'>تایید نشده</span>",
            1: "<span class='badge badge-success'>تایید شده</span>",
            2: "<span class='badge badge-primary'>بررسی نشده</span>",
        };
    }

    contentRemoveHandler() {
        const buttons = document.querySelectorAll( ".btn-remove-content" );

        buttons.forEach( button => {
            button.addEventListener( "click", ( e ) => {
                const button = e.target.closest( ".btn-remove-content" );
                if ( ! button ) return console.error( "button not found" );
                this.contentRemoveHandlerEvent.call( this, button );
            } );
        } );
    }

    contentRemoveHandlerEvent( button ) {
        sweetAlertConfirm( () => {
            const content_id = button.closest( "[data-id]" ).getAttribute( "data-id" );

            const data = {
                data    : {
                    content_id: content_id,
                },
                method  : "POST",
            };

            ajaxFetch( this.state.item_content_remove, this.contentRemoveHandlerEventSuccess.bind( button ), data );
        } );
    }

    contentRemoveHandlerEventSuccess( respond ) {
        if ( respond.status !== "success" ) {
            sweetAlert( respond );
            return;
        }
        sweetAlert( respond );
        this.closest( "tr" ).remove();
    }

    contentPageHandler() {
        const pages = document.querySelectorAll( ".page-handler" );

        pages.forEach( page => {
            page.addEventListener( "click", ( e ) => {
                const td = e.target;
                if ( td.tagName.toUpperCase() === "INPUT" ) return ;
                this.contentPageHandlerEvent.call( this, td.closest( "td" ) );
            } );
        } );
    }

    contentPageHandlerEvent( td ) {

        const save = () => {
            const text = td.querySelector( "input" ).value.trim();

            td.innerHTML = "";
            td.insertAdjacentHTML( "afterbegin", `${ text }` );
            
            td.classList.remove( "active" );

            const content_id = td.closest( "[data-id]" ).getAttribute( "data-id" );

            const data = {
                data    : {
                    content_id: content_id,
                    page: text,
                    is_page: true,
                },
                method  : "POST",
            };

            ajaxFetch( this.state.item_content_update, this.contentPageHandlerEventSuccess, data );
        }

        if ( td.classList.contains( "active" ) ) {

            save();

        } else {

            const text = td.innerHTML.trim();

            td.innerHTML = "";
            td.insertAdjacentHTML( "afterbegin", `<input type="number" class="form-control form-control-sm input-enter-save" value="${ text }"/>` );

            td.classList.add( "active" );
            
            this.eventKeyUpEnterHandler( save );
        }
    }

    contentPageHandlerEventSuccess( respond ) {
        sweetAlert( respond );
    }

    contentStatusHandler() {
        const Statuses = document.querySelectorAll( ".status-handler" );

        Statuses.forEach( status => {
            status.addEventListener( "click", ( e ) => {
                const td = e.target;
                if ( td.tagName.toUpperCase() === "INPUT" ) return ;
                this.contentStatusHandlerEvent.call( this, td.closest( "td" ) );
            } );
        } );
    }

    contentStatusHandlerEvent( td ) {

        const save = () => {
            const text = td.querySelector( "input" ).value.trim();

            td.innerHTML = "";
            td.insertAdjacentHTML( "afterbegin", `${ this.status[ text ] }` );
            
            td.classList.remove( "active" );
            
            const content_id = td.closest( "[data-id]" ).getAttribute( "data-id" );

            const data = {
                data    : {
                    content_id: content_id,
                    status: text,
                    is_status: true,
                },
                method  : "POST",
            };

            ajaxFetch( this.state.item_content_update, this.contentStatusHandlerEventSuccess, data );
        }

        if ( td.classList.contains( "active" ) ) {

            save();

        } else {

            const text = td.querySelector( "span" ).classList;

            td.innerHTML = "";
            td.insertAdjacentHTML( "afterbegin", `<input type="number" class="form-control form-control-sm input-enter-save" value="${ this.statusTextToNumber( text ) }"/>` );

            td.classList.add( "active" );
            
            this.eventKeyUpEnterHandler( save );
        }
    }

    contentStatusHandlerEventSuccess( respond ) {
        sweetAlert( respond );
    }

    statusTextToNumber( class_name ) {
        if ( class_name.contains( "badge-danger" ) ) {
            return 0;
        } else if ( class_name.contains( "badge-success" ) ) {
            return 1;
        } else {
            return 2;
        }
    }

    eventKeyUpEnterHandler( callback ) {
        document.querySelector( ".input-enter-save" ).addEventListener( "keyup", ( e ) => {

            if ( e.which !== 13 ) return;

            callback();
        } );
    }

    contentUpdateColumnHandler( column_name ) {

        this.contentColumnHandler( column_name );
    }

    contentColumnHandler( column_name ) {
        const items = document.querySelectorAll( `.${ column_name }-handler` );

        items.forEach( item => {
            item.addEventListener( "click", ( e ) => {
                const td = e.target;
                if ( td.tagName.toUpperCase() === "INPUT" ) return ;
                this.contentColumnHandlerEvent.call( this, td.closest( "td" ), column_name );
            } );
        } );
    }

    contentColumnHandlerEvent( td, column_name ) {

        const save = () => {
            const text = td.querySelector( "input" ).value.trim();

            td.innerHTML = "";
            td.insertAdjacentHTML( "afterbegin", `${ text }` );
            
            td.classList.remove( "active" );

            const content_id = td.closest( "[data-id]" ).getAttribute( "data-id" );

            const data = {
                data : {
                    content_id: content_id,
                },
                method  : "POST",
            };

            data.data[ column_name ] = text;
            data.data[ `is_${ column_name }` ] = true;

            ajaxFetch( this.state.item_content_update, this.contentColumnHandlerEventSuccess, data );
        }

        if ( td.classList.contains( "active" ) ) {

            save();

        } else {

            const text = td.innerHTML.trim();

            td.innerHTML = "";
            td.insertAdjacentHTML( "afterbegin", `<input type="text" class="form-control form-control-sm input-enter-save" value="${ text }"/>` );

            td.classList.add( "active" );
            
            this.eventKeyUpEnterHandler( save );
        }
    }

    contentColumnHandlerEventSuccess( respond ) {
        sweetAlert( respond );
    }

    contentBookIdHandler() {
        const book_ids = document.querySelectorAll( ".book-title-handler" );

        book_ids.forEach( book_id => {
            book_id.addEventListener( "click", ( e ) => {
                const td = e.target;
                if ( td.tagName.toUpperCase() === "SELECT" ) return ;
                this.contentBookIdHandlerEvent.call( this, td.closest( "td" ) );
            } );
        } );
    }

    async contentBookIdHandlerEvent( td ) {

        const save = () => {
            const select_box = td.querySelector( "select" );

            const select_value = select_box.value.trim();
            const select_text = select_box.options[select_box.selectedIndex].text;

            td.innerHTML = "";
            td.insertAdjacentHTML( "afterbegin", `${ select_text }` );
            td.setAttribute( "data-book-id", select_value );
            
            td.classList.remove( "active" );
            
            const content_id = td.closest( "[data-id]" ).getAttribute( "data-id" );

            const data = {
                data    : {
                    content_id: content_id,
                    book_id: select_value,
                    is_book_id: true,
                },
                method  : "POST",
            };

            ajaxFetch( this.state.item_content_update, this.contentBookIdHandlerEventSuccess, data );
        }

        if ( td.classList.contains( "active" ) ) {

            save();

        } else {

            if ( this.state.list_all_books.length < 1 ) {
                const saveAllBooks = ( respond ) => {
                    this.state.list_all_books = respond.data;
                }

                const data = {
                    data : {},
                    method  : "GET",
                };
                await ajaxFetch( this.state.list_all_books_url, saveAllBooks, data );
            }

            const loadAllBooksOptions = ( current_book_id ) => {
                return this.state.list_all_books.map( option => {
                    return `<option value="${ option.id }" ${ current_book_id === option.id ? "selected" : "" }>${ option.title }</option>`;
                } );
            }

            const current_book_id = td.dataset.bookId;

            td.innerHTML = "";
            td.insertAdjacentHTML( "afterbegin", `
                <select class="custom-select custom-select-sm input-enter-save">
                ${ loadAllBooksOptions( current_book_id ) }
                </select>
                ` );

            td.classList.add( "active" );
            
            this.eventKeyUpEnterHandler( save );
        }
    }

    contentBookIdHandlerEventSuccess( respond ) {
        sweetAlert( respond );
    }
}

docReady( ManageContentBook.documentReadyFunction );