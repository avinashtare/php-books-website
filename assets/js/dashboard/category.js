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

// add category form 1
let add_category_form = document.getElementById("add_category_form");

// delete category form
let delete_category_form = document.getElementById("delete_category_form");


async function handle_category_form(e) {
    e.preventDefault()
    let book_title = document.getElementById("add-book-title");
    let book_category = document.getElementById("add-book-category");

    // send request 
    let url = "/admin/api/category/add-category.php";
    let data = { title: book_title.value, category: book_category.value };
    let response = await sendFetchRequest(url, "POST", data);
    response = await response.json()

    if (!response.error) {
        book_title.value = "";
        book_category.value = "";
    }
    // show message
    showMessage(response.message);
};

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
let DeleteBookCategoryInput = document.getElementById("delete-book-category");
let deleteCategoryModal = DeleteBookCategoryInput.parentElement.querySelector(".search-modal");

// update element when data comes from server
function deleteCategoryElementUpdate() {
    let alldata = deleteCategoryModal.children;
    Array.from(alldata).forEach(dataElem => {
        dataElem.addEventListener("click", () => {
            DeleteBookCategoryInput.setAttribute("data-id", dataElem.getAttribute("data-id"));
            DeleteBookCategoryInput.value = dataElem.innerText;
        });
    });
};

// category show on delete modal
async function handelDeleteCategoryList(searchArg) {
    let categoryList = await searchCategoryRequest(searchArg);
    let jsonResponse = await categoryList.json();
    deleteCategoryModal.innerHTML = "";
    jsonResponse.forEach(categoryData => {
        deleteCategoryModal.innerHTML += `<span data-id="${categoryData.id}">${categoryData.category}</span>`;
    });

    // update elemnts
    deleteCategoryElementUpdate()
}

// speed of request data from server
const searchCategoryDebounce = debounce(handelDeleteCategoryList, 300);
DeleteBookCategoryInput.addEventListener("input", (e) => {
    let categorySearchData = DeleteBookCategoryInput.value;
    searchCategoryDebounce(categorySearchData)
})

// handle delete 
async function handle_category_delete(e) {
    e.preventDefault()
    let book_category_elem = document.getElementById("delete-book-category");
    book_category  = Number(book_category_elem.getAttribute("data-id"))
    
    if(book_category.length == 0 && filter_var($value, FILTER_VALIDATE_INT) == false){
        showMessage("Place Select a category.");
        return false;
    }
    // send request 
    let url = "/admin/api/category/delete-category.php";
    let data = { category: book_category };
    let response = await sendFetchRequest(url, "POST", data);
    response = await response.json()

    if (!response.error) {
        book_category_elem.removeAttribute("data-id")
        book_category_elem.value = "";
    }
    // show message
    console.log(response)
    showMessage(response.message);
};


// handle category form 
delete_category_form.addEventListener("submit", handle_category_delete);
// handle category delete 
add_category_form.addEventListener("submit", handle_category_form);