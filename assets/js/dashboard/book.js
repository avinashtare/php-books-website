// global varables,function 
// search slowly by user typing
function debounce(func, delay) {
    let timeoutId;
    return function (...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            func(...args);
        }, delay);
    };
}


// send http request
async function sendFetchRequest(url, method, data) {
    const request = {
        method: method,
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(data), // body data type must match "Content-Type" header
    };
    let response = await fetch(url, request);

    return response;
}

// get category from server 
async function searchCategoryRequest(searchArg) {
    let url = "/admin/api/category/search-category.php";
    let method = "POST";
    let data = ({ category: searchArg });

    let categoryData = await sendFetchRequest(url, method, data)

    return categoryData;
}
// get name by category 
async function searchBookNameRequest(searchArg, category) {
    let url = "/admin/api/book/search-books.php";
    let method = "POST";
    let data = ({ bookname: searchArg, category: category });

    let categoryData = await sendFetchRequest(url, method, data)

    return categoryData;
}

// search modal input handel
let searchModalInputs = document.querySelectorAll(".search-modal-input");

// handle search modals
searchModalInputs.forEach((searchInput) => {
    let parentElem = searchInput.parentElement;
    let search_modal = parentElem.querySelector(".search-modal");
    // handle blur click
    searchInput.addEventListener("click", () => {
        search_modal.classList.remove("hide");
    });

    // handle blur event 
    searchInput.addEventListener("blur", () => {
        setTimeout(() => {
            search_modal.classList.add("hide");
        }, 100);
    });

    // click event handle / save it ther input as data-id=?
    searchInput.addEventListener("keydown", (e) => {
        search_modal.classList.remove("hide");

        let alldata = search_modal.children;
        Array.from(alldata).forEach(dataElem => {
            dataElem.addEventListener("click", () => {
                searchInput.setAttribute("data-id", dataElem.getAttribute("data-id"));
            });
        });
    })
});


// show cateogry on modal
let AddBookInput = document.getElementById("add_book_category");
let AddBookInputModal = AddBookInput.parentElement.querySelector(".search-modal");

// update element when data comes from server
function addBookElementUpdate() {
    let alldata = AddBookInputModal.children;
    Array.from(alldata).forEach(dataElem => {
        dataElem.addEventListener("click", () => {
            AddBookInput.setAttribute("data-id", dataElem.getAttribute("data-id"));
            AddBookInput.value = dataElem.innerText;
        });
    });
};

// category show on delete modal
async function handelAddBookList(searchArg) {
    let categoryList = await searchCategoryRequest(searchArg);
    let jsonResponse = await categoryList.json();
    AddBookInputModal.innerHTML = "";
    jsonResponse.forEach(categoryData => {
        AddBookInputModal.innerHTML += `<span data-id="${categoryData.id}">${categoryData.category}</span>`;
    });

    // update elemnts
    addBookElementUpdate();
};

// speed of request data from server
let searchCategoryDebounce = debounce(handelAddBookList, 300);
AddBookInput.addEventListener("input", (e) => {
    let categorySearchData = AddBookInput.value;
    searchCategoryDebounce(categorySearchData)
})


// handle add book form 
const add_book_form = document.getElementById("add_book_form");
async function handle_add_book_form(e) {
    e.preventDefault()
    let book_name = document.getElementById("add_book_name");
    let book_category = document.getElementById("add_book_category");
    let book_poster_url = document.getElementById("add_book_poster_url");
    let book_download_url = document.getElementById("add_book_download_url");

    // validation
    if (book_category.getAttribute("data-id") == null) { showMessage("Choose Category."); return 0 };
    if (book_name.value.length == 0) { showMessage("Name Length Gratter then 0."); return 0 };

    let data = { name: book_name.value, category: Number(book_category.getAttribute("data-id")), poster: book_poster_url.value, downlaod: book_download_url.value };
    let url = "/admin/api/book/add-book.php";
    let response = await sendFetchRequest(url, "POST", data)
    response = await response.json();

    if (!response.error) {
        book_category.removeAttribute("data-id")
        book_category.value = "";
        book_name.value = "";
        book_poster_url.value = "";
        book_download_url.value = "";
    }
    // show message
    showMessage(response.message);
};

// submit add book event
add_book_form.addEventListener("submit", handle_add_book_form);


// form 2

// form to delete book
const delete_book_name_form = document.getElementById("delete_book_name_form");
const delete_book_category = document.getElementById("delete_book_category")
const delete_book_name = document.getElementById("delete_book_name")


// show cateogry on modal
let DeleteBookCategoryInputModal = delete_book_category.parentElement.querySelector(".search-modal");
let DeleteBookNameInputModal = delete_book_name.parentElement.querySelector(".search-modal");

// update element when data comes from server
function updateSelectElements(element, mainElem) {
    let alldata = element.children;
    Array.from(alldata).forEach(dataElem => {
        dataElem.addEventListener("click", () => {
            mainElem.setAttribute("data-id", dataElem.getAttribute("data-id"));
            mainElem.value = dataElem.innerText;
        });
    });
};

// category show on delete modal
async function handleOptionsList(searchArg, fetchArg, element, updateElements, inputElem) {
    let categoryList;

    async function setElementToOptions(arg1, arg2) {
        let jsonResponse = await categoryList.json();
        element.innerHTML = "";
        if (jsonResponse) {
            jsonResponse.forEach(categoryData => {
                element.innerHTML += `<span data-id="${categoryData[arg1]}">${categoryData[arg2]}</span>`;
            });
        }
    };

    switch (fetchArg) {
        case "category":
            categoryList = await searchCategoryRequest(searchArg);
            await setElementToOptions("id", "category");
            break;
        case "bookname":
            let { bookName, cateogryId } = searchArg;
            categoryList = await searchBookNameRequest(bookName, cateogryId);
            await setElementToOptions("id", "book_name");
            break;
    };

    // update elemnts
    updateElements(element, inputElem);
};

// speed of request data from server
let searchCategoryDebounceDelete = debounce(handleOptionsList, 300);
delete_book_category.addEventListener("input", (e) => {
    // remove data id
    delete_book_category.removeAttribute("data-id");
    // clear delete book value
    delete_book_name.value = "";
    DeleteBookCategoryInputModal.innerHTML = "";
    DeleteBookNameInputModal.innerHTML = "";

    // get search value
    let categorySearchData = delete_book_category.value;
    searchCategoryDebounceDelete(categorySearchData, "category", DeleteBookCategoryInputModal, updateSelectElements, delete_book_category)
});

function handleDeleteBookInput() {
    // remove data id
    delete_book_name.removeAttribute("data-id");

    let argBookName = delete_book_name.value;
    let argBookCategory = delete_book_category.getAttribute("data-id");
    if (argBookCategory != null) {
        let fetchData = { bookName: argBookName, cateogryId: argBookCategory };
        searchCategoryDebounceDelete(fetchData, "bookname", DeleteBookNameInputModal, updateSelectElements, delete_book_name);
    }
    else {
        delete_book_name.disable = true;
        delete_book_name.value = "";
        showMessage("Select Category Input.");
    }
}

// delete book handle 
async function handle_delete_book_form(e) {
    e.preventDefault();
    let bookNameId = Number(delete_book_name.getAttribute("data-id")) || null;
    // validaton
    if (bookNameId == null ||  bookNameId.length == 0) {
        showMessage("Check Category & Bookname.")
        return false;
    };

    let data = { bookId: bookNameId };
    let url = "/admin/api/book/delete-book.php";
    let response = await sendFetchRequest(url, "POST", data);
    response = await response.json();

    if (!response.error) {
        // remove data id
        delete_book_name.removeAttribute("data-id");
        delete_book_category.removeAttribute("data-id");
        // clear delete book value
        delete_book_name.value = "";
        delete_book_category.value = "";
        DeleteBookCategoryInputModal.innerHTML = "";
        DeleteBookNameInputModal.innerHTML = "";
    }
    // show message
    showMessage(response.message);

}

// hanlde delete book input
delete_book_name.addEventListener("input", handleDeleteBookInput);

// submit delete book event
delete_book_name_form.addEventListener("submit", handle_delete_book_form);