function changeSort(select) {
    currentSort = select.value;
    const url = '/category/' + currentCategoryId + '/' + currentSort;
    getProductsList(url);
}

function changeCategory(categoryId) {
    if (currentCategoryId === categoryId) {
        return;
    }

    currentCategoryId = categoryId;
    const url = '/category/' + categoryId + (currentSort ? '/' + currentSort : '');
    getProductsList(url);
}

function getProductsList(url) {
    let request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (this.readyState === 4) {
            if (this.status === 200) {
                try {
                    let response = JSON.parse(this.responseText);

                    updateProductsList(response);
                } catch (err) {
                    console.error(err.message + " in " + this.responseText);
                }
            } else {
                console.error("AJAX error");
            }
        }
    };
    request.open("GET", url, true);
    request.send();
}

function updateProductsList(response) {
    if (response.currentCategory !== null) {
        currentCategoryId = response.currentCategory.id;
        document.getElementById('productsListCaption').textContent = response.currentCategory.name;
    }

    const productsWrapper = document.getElementById('productsWrapper');
    clearElementChildren(productsWrapper);
    addProducts(productsWrapper, response.products);

    updateUrl();
}

function clearElementChildren(element) {
    while (element.firstChild) {
        element.removeChild(element.lastChild);
    }
}

function addProducts(wrapper, products) {
    let newProduct = '';
    products.forEach((product) => {
        newProduct += `<div class="p-2">
                <p class="lead">${product.name}</p>
                ${product.priceFormatted } грн.<br>
                ${product.createdAt}<br>
                <button class="btn btn-primary btn-sm" onclick="showProductDetails(${product.id})">Купити</button>
            </div>`;

        wrapper.innerHTML = newProduct;
    });
}

function updateUrl() {
    let queryParams = [];
    if (currentCategoryId) {
        queryParams.push('c=' + currentCategoryId);
    }
    if (currentSort) {
        queryParams.push('sort=' + currentSort);
    }
    const newUrl = window.location.protocol + '//' + window.location.host + '/?' + queryParams.join('&');

    window.history.pushState({}, '', newUrl);
}

function showProductDetails(productId) {
    const url = '/product/' + productId;

    let request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (this.readyState === 4) {
            if (this.status === 200) {
                try {
                    let response = JSON.parse(this.responseText);

                    const productModalElement = document.getElementById('productModal');
                    productModalElement.querySelector('#productModalLabel').textContent = response.name;
                    productModalElement.querySelector('#productModalPrice').textContent = response.priceFormatted;
                    productModalElement.querySelector('#productModalCreatedDate').textContent = response.createdAt;

                    const myModal = new bootstrap.Modal(productModalElement);
                    myModal.show();
                } catch (err) {
                    console.error(err.message + " in " + this.responseText);
                }
            } else {
                console.error("AJAX error");
            }
        }
    };
    request.open("GET", url, true);
    request.send();
}
