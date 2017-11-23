var csrf_token = undefined;

$(document).ready(() => {
    csrf_token = $('meta[name="csrf-token"]').attr('content');

    if(csrf_token){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrf_token
            }
        });
    }else{
        toggleInfoModal("Some operations may not work correctly. Please contact the administrator");
    }
});

//-----General------

function toggleInfoModal(infoBody, onCloseFunc){
    document.getElementById('info-body').innerText = infoBody;

    $('#info-modal').modal('toggle');

    if(onCloseFunc != undefined && onCloseFunc != null){
        $('#info-modal').on('hidden.bs.modal', function (e) {
            onCloseFunc();
        });
    }
}

function showModalToChangeCity(){
    $.get('/City/GetAllAsJson').done(data => {
        var cities = JSON.parse(data);

        cities.forEach(city => {
            $("#selectableCities").append("<li class='list-group-item list-group-item-action' onclick='citySelected("+ city.id +")'>"+ city.name +"</li>")
        });
        $('#change-selected-city-modal').modal('toggle');
        
    }).fail(err => {
        toggleInfoModal("Something went wrong please try again");
    });
}

//------Welcome------

function citySelected(selectedCityParam){
    var selectedCity = selectedCityParam || document.getElementById('selectedCity').value;
    if(selectedCity != undefined && selectedCity != null && selectedCity.toString().trim() != ""){
        $.post('/CitySelected', {selectedCity : selectedCity}).done(data => {
            var result = JSON.parse(data);
            if(result.isSucceeded){
                window.location = window.location;
            }else{
                toggleInfoModal("Something went wrong while setting up the city for you. Please try again");
            }
            
        }).fail(err => {
            toggleInfoModal("Something went wrong please try again");
        });
    }
}

//-----End Welcome----
//------Producer-------

// Modify
var producerToModify = {};
function showModifyProducerModal(producerId, name) {
    producerToModify.id = producerId;
    producerToModify.name = name;
    document.getElementById('new-product-name').value = name;
    $('#modify-producer-modal').modal('toggle');
}


function modifyProducer(){
    if(document.getElementById('new-product-name').value != undefined && document.getElementById('new-product-name').value.trim() != ""){
        producerToModify.name = document.getElementById('new-product-name').value;
        $.post("/Producer/Update", producerToModify).done(data => {
            var result = JSON.parse(data);

            if(result.isSucceeded){
                toggleInfoModal("Producer name has been succesfully updated", () => {window.location = window.location});
            }else{
                toggleInfoModal("Something went wrong while modifying the producer. Please try again");
            }
            
        }).fail(err => {
            toggleInfoModal("Something went wrong please try again");
        });
    }else{
        toggleInfoModal("Please enter a valid name");
    }
}

//-----End Producer------



//------Category-------

// Modify
var categoryToModify = {};
function showModifyCategoryModal(producerId, name) {
    categoryToModify.id = producerId;
    categoryToModify.name = name;
    document.getElementById('new-category-name').value = name;
    $('#modify-category-modal').modal('toggle');
}


function modifyCategory(){
    if(document.getElementById('new-category-name').value != undefined && document.getElementById('new-category-name').value.trim() != ""){
        categoryToModify.name = document.getElementById('new-category-name').value;
        $.post("/Category/Update", categoryToModify).done(data => {
            var result = JSON.parse(data);

            if(result.isSucceeded){
                toggleInfoModal("Category name has been succesfully updated", () => {window.location = window.location});
            }else{
                toggleInfoModal("Something went wrong while modifying the category. Please try again");
            }
            
        }).fail(err => {
            toggleInfoModal("Something went wrong please try again");
        });
    }else{
        toggleInfoModal("Please enter a valid name");
    }
}

//-----End Category------

//------City-------

// Modify
var cityToModify = {};
function showModifyCityModal(producerId, name) {
    cityToModify.id = producerId;
    cityToModify.name = name;
    document.getElementById('new-city-name').value = name;
    $('#modify-city-modal').modal('toggle');
}


function modifyCity(){
    if(document.getElementById('new-city-name').value != undefined && document.getElementById('new-city-name').value.trim() != ""){
        categoryToModify.name = document.getElementById('new-city-name').value;
        $.post("/City/Update", categoryToModify).done(data => {
            var result = JSON.parse(data);

            if(result.isSucceeded){
                toggleInfoModal("City name has been succesfully updated", () => {window.location = window.location});
            }else{
                toggleInfoModal("Something went wrong while modifying the city. Please try again");
            }
            
        }).fail(err => {
            toggleInfoModal("Something went wrong please try again");
        });
    }else{
        toggleInfoModal("Please enter a valid name");
    }
}

//-----End City------


//------User---------

//Modify User
var userToModify = {};
var currentUserId = undefined;
function showModifyUserModal(userId){
    if(userId != undefined && userId != null){
        userToModify.id = currentUserId = userId;
        document.getElementById('new-user-fullname').value = document.getElementById('fullname-' + userId).innerText;
        document.getElementById('new-user-email').value = document.getElementById('email-' + userId).innerText;
        document.getElementById('new-user-address').value = document.getElementById('address-' + userId).innerText;
        $("#modify-user-modal").modal('toggle');
    }
    
}

function modifyUser(){
    userToModify.fullname = document.getElementById('new-user-fullname').value;
    userToModify.email = document.getElementById('new-user-email').value;
    userToModify.address = document.getElementById('new-user-address').value;

    if(userToModify.fullname != undefined && userToModify.fullname != null && userToModify.fullname.trim() != "" &&
        userToModify.email != undefined && userToModify.email != null && userToModify.email.trim() != "" &&
        userToModify.address != undefined && userToModify.address != null && userToModify.address.trim() != ""){
            $.post("/User/Update", userToModify).done(data => {
                var result = JSON.parse(data);
                if(result.isSucceeded){
                    toggleInfoModal("User has been succesfully updated", () => {window.location = window.location});
                }else{
                    toggleInfoModal("Something went wrong while modifying the user. Please try again");
                }
                
            }).fail(err => {
                toggleInfoModal("Something went wrong please try again");
            });
        }else{
            toggleInfoModal("Your inputs should be valid");
        }
}

function blockUser(userId){
    if(userId != undefined && userId != null && userId.toString().trim() != ""){
        $.post("/Account/Block", {id : userId}).done(data => {
            var result = JSON.parse(data);
            if(result.isSucceeded){
                toggleInfoModal(result.messages.join('.'), () => {window.location = window.location});
            }else{
                toggleInfoModal(result.messages.join('.') + ". Please try again");
            }
            
        }).fail(err => {
            toggleInfoModal("Something went wrong please try again");
        });
    }else{
        toggleInfoModal("Please try again");
    }
}

function unblockUser(userId){
    if(userId != undefined && userId != null && userId.toString().trim() != ""){
        $.post("/Account/Unblock", {id : userId}).done(data => {
            var result = JSON.parse(data);
            if(result.isSucceeded){
                toggleInfoModal(result.messages.join('.'), () => {window.location = window.location});
            }else{
                toggleInfoModal(result.messages.join('.') + ". Please try again");
            }
            
        }).fail(err => {
            toggleInfoModal("Something went wrong please try again");
        });
    }else{
        toggleInfoModal("Please try again");
    }
}

function makeAdmin(userId){
    if(userId != undefined && userId != null && userId.toString().trim() != ""){
        $.post("/User/MakeAdmin", {id : userId}).done(data => {
            var result = JSON.parse(data);
            if(result.isSucceeded){
                toggleInfoModal(result.messages.join('.'), () => {window.location = window.location});
            }else{
                toggleInfoModal(result.messages.join('.') + ". Please try again");
            }
            
        }).fail(err => {
            toggleInfoModal("Something went wrong please try again");
        });
    }else{
        toggleInfoModal("Please try again");
    }
}

function removeAdmin(userId){
    if(userId != undefined && userId != null && userId.toString().trim() != ""){
        $.post("/User/RemoveAdmin", {id : userId}).done(data => {
            var result = JSON.parse(data);
            if(result.isSucceeded){
                toggleInfoModal(result.messages.join('.'), () => {window.location = window.location});
            }else{
                toggleInfoModal(result.messages.join('.') + ". Please try again");
            }
            
        }).fail(err => {
            toggleInfoModal("Something went wrong please try again");
        });
    }else{
        toggleInfoModal("Please try again");
    }
}

function showDeleteUserModal(userId){
    if(userId != undefined && userId != null){
        currentUserId = userId;
        $("#delete-user-modal").modal('show');
    }
}

function deleteUser(){
    if(currentUserId != undefined && currentUserId != null && currentUserId.toString().trim() != ""){
        $.post("/User/Delete", {id : currentUserId}).done(data => {
            var result = JSON.parse(data);
            if(result.isSucceeded){
                toggleInfoModal(result.messages.join('.'), () => {window.location = window.location});
            }else{
                toggleInfoModal(result.messages.join('.') + ". Please try again");
            }
            
        }).fail(err => {
            toggleInfoModal("Something went wrong please try again");
        });
    }else{
        toggleInfoModal("Please try again");
    }
}

//-----End User------

//-------Product----------

//Update stock

var productAvailability = undefined;
function updateProductStock(cityId){
    productAvailability = {
        city_id : cityId,
        product_id : document.getElementById('product-id').value,
        quantity : document.getElementById('stock-' + cityId).value
    };
    if(cityId != undefined && cityId != null && cityId.toString().trim() != "" && 
        productAvailability.product_id != undefined && productAvailability.product_id != null && productAvailability.product_id.toString().trim() != "" &&
        productAvailability.quantity != undefined && productAvailability.quantity != null && productAvailability.quantity.toString().trim() != ""){
        
            $.post('/Product/' + productAvailability.product_id + '/Stock/Update/', productAvailability).done(data => {
            var result = JSON.parse(data);
            console.log(result)
            if(result.isSucceeded){
                toggleInfoModal(result.messages.join('.'), () => {window.location = window.location});
            }else{
                toggleInfoModal(result.messages.join('.') + ". Please try again");
            }
            
        }).fail(err => {
            toggleInfoModal("Something went wrong please try again");
        });
    }else{
        toggleInfoModal("Please enter valid quantity");
    }
}

function computeTotalPrice(unitPrice){
    document.getElementById('totalPrice').innerText = unitPrice * document.getElementById('quantity').value + "€";
}
//-------End Product------


//--------Cart-------

function addToCart(productId, unitPrice){
    if(productId != undefined && productId != null && productId.toString().trim() != "" && isNaN(productId) == false && 
        unitPrice != undefined && unitPrice != null && unitPrice.toString().trim() != "" && isNaN(unitPrice) == false){
        var quantityToAdd = document.getElementById('quantity').value;
        if(quantityToAdd != undefined && quantityToAdd != null && quantityToAdd.toString().trim() != "" && isNaN(quantityToAdd) == false){
            $.post('/Cart/Add', {
                product_id : productId,
                quantity : quantityToAdd,
                unit_price : unitPrice
            }).done(data => {
                var result = JSON.parse(data);
                if(result.isSucceeded){
                    toggleInfoModal(result.messages.join('.'), () => {window.location = window.location});
                }else{
                    toggleInfoModal(result.messages.join('.') + ". Please try again");
                }
            }).fail(err => {
                toggleInfoModal("Something went wrong please try again");
            });
        }
    }
}

function updateQuantity(productId){
    if(productId != undefined && productId != null && productId.toString().trim() != "" && isNaN(productId) == false){
        var newQuantity = document.getElementById('product-' + productId + '-quantity').value;
        if(newQuantity != undefined && newQuantity != null && newQuantity.toString().trim() != "" && isNaN(newQuantity) == false){
            $.post('/Cart/Update/Quantity', {
                product_id : productId,
                quantity : newQuantity
            }).done(data => {
                var result = JSON.parse(data);
                if(result.isSucceeded){
                    toggleInfoModal(result.messages.join('.'), () => {window.location = window.location});
                }else{
                    toggleInfoModal(result.messages.join('.') + ". Please try again");
                }
            }).fail(err => {
                toggleInfoModal("Something went wrong please try again");
            });
        }
        
    }
}

function removeProductFromCart(productId){
    if(productId != undefined && productId != null && productId.toString().trim() != "" && isNaN(productId) == false){
        $.post('/Cart/Product/Remove', {
            product_id : productId
        }).done(data => {
            var result = JSON.parse(data);
            if(result.isSucceeded){
                toggleInfoModal(result.messages.join('.'), () => {window.location = window.location});
            }else{
                toggleInfoModal(result.messages.join('.') + ". Please try again");
            }
        }).fail(err => {
            toggleInfoModal("Something went wrong please try again");
        });        
    }
}