var searchInput = document.getElementById('search');
var searchResults = document.getElementById('searchResults');
var searchbtn = document.getElementById('bouton123');
var searchResult = document.getElementById('Recipiezone12');
var searchTitle1 = document.getElementById('searchtitle12');
var searchTitleTxt = document.getElementById('searchtitletxt1');


document.addEventListener('DOMContentLoaded', function() {
    var urlParams = new URLSearchParams(window.location.search);
    var searchQuery = urlParams.get('search');
    
    // If searchQuery exists, perform the search
    if (searchQuery) {
        searchInput.value = searchQuery;
        searchTitleTxt.innerText = "Search Result";
        searchTitle1.style.padding = '50px';
        ajaxRequest('POST', 'add_result.php', addElement);
        

    }
    // Add event listener to the search button
    searchbtn.addEventListener('click', function(event) {
        event.preventDefault();

        var currentURL = window.location.href;
        var searchQuery = searchInput.value.trim();
        // Check if the current URL contains 'recipes.php'
        if (currentURL.includes('Recipes.php')) {
            searchTitleTxt.innerText = "Search Result";
            searchTitle1.style.padding = '50px';
            // Perform the search directly without redirection
            ajaxRequest('POST', 'add_result.php', addElement);
        } else {
            // Redirect to the recipes page with the search query as a URL parameter
            window.location.href = 'Recipes.php?search=' + encodeURIComponent(searchQuery);
        }
    });

    // Add event listener to the search input for keyup event
    searchInput.addEventListener('keyup', function() {
        var searchQuery = this.value.trim(); // Get the value of the search input and trim any leading/trailing whitespace

        if (searchQuery.length === 0) {
            searchResults.innerHTML = ''; // Clear search results if search query is empty
            return;
        }
        searchResults.innerHTML = '';
        ajaxRequest('POST', 'search.php', suggest);

    });    
});

function ajaxRequest(action, url, func) {
    // Create a new XMLHttpRequest object
    var xhr = new XMLHttpRequest();

    // Specify the URL of the PHP script (auto_loader.php) and the request method (POST)
    xhr.open('POST', url, true);

    // Define the function to be called when the request state changes
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) { // When the request is complete
            if (xhr.status === 200) { // If the request was successful
                // Update the search results container with the response from the server
                func(xhr);
            
            } else {
                console.error('Request failed: ' + xhr.status); // Log an error if the request fails
            }
        }
    };

    // Prepare the data to be sent (search query)
    var formData = new FormData();
    formData.append('search', searchInput.value.trim());

    // Send the request with the form data
    xhr.send(formData);
}

function suggest(xhr) {
    console.log(xhr.responseText);
    // Parse the JSON response
    var jsonResponse = JSON.parse(xhr.responseText);

    // Clear existing content
    searchResults.innerHTML = '';

    // Iterate over each array element and create list items
    jsonResponse.forEach(function(item) {
        // Create list item element
        var listItem = document.createElement('li');

        // Set text content of list item to the first element of the inner array
        listItem.textContent = item[0];
        
        // Add onclick handler to list item
        listItem.addEventListener('click', function() {
            selectInput(item[0], xhr);
        });

        // Append list item to the search results container
        searchResults.appendChild(listItem);
    });
    
    //search input blur and focus
    searchInput.addEventListener('blur', () => {
        // Hide the search list
        if(!searchResults.matches(':hover')){
             searchResults.style.display = 'none';
        }
    }); 
    searchInput.addEventListener('focus', () => {
        // Show the search list
        searchResults.style.display = 'block';
    });
    
    // Listen for mouseover event on the search result list to keep it visible
    searchResults.addEventListener('mouseover', () => {
        // Show the search list
        searchResults.style.display = 'block';
    });    
}

function addElement(xhr) {
    // Parse the JSON response into an array of objects
    var jsonResponse = JSON.parse(xhr.responseText);
    
    // Clear the existing content
    searchResult.innerHTML = "";

    // Iterate over the array of objects and create elements accordingly
    jsonResponse.forEach(function(recipe) {
        createRecipeCard(recipe,"container");
    });
}

function selectInput(textContent, xhr) {
    searchInput.value = textContent;
    searchResults.innerHTML = ''; 
    searchInput.focus(); // Clear search results after selecting input
}


function createRecipeCard(recipe) {
    // Create elements
    var cardDiv = document.createElement("div");
    cardDiv.className = "card";
    
    var headerDiv = document.createElement("div");
    headerDiv.className = "header";
    
    var img = document.createElement("img");
    img.src = "img/recepie/" + recipe.Image;
    img.alt = "food";
    
    var iconDiv = document.createElement("div");
    iconDiv.className = "icon";
    
    var heartLink = document.createElement("a");
    heartLink.href = "#";
    
    var heartIcon = document.createElement("i");
    heartIcon.className = "fa fa-heart-o";
    
    var textDiv = document.createElement("div");
    textDiv.className = "text";
    
    var foodHeader = document.createElement("h3");
    foodHeader.className = "food";
    foodHeader.textContent = recipe.Name;
    
    var timeIcon = document.createElement("i");
    timeIcon.className = "fa fa-clock-o";
    timeIcon.textContent = " " + recipe.Time + " Mins";
    
    var servesIcon = document.createElement("i");
    servesIcon.className = "fa fa-users";
    servesIcon.textContent = " Serves " + recipe.NbServings;
    
    var starsDiv = document.createElement("div");
    starsDiv.className = "stars";
    
    // This part may vary depending on your rating data structure
    for (var i = 0; i < recipe.Rating; i++) {
        var starLink = document.createElement("a");
        starLink.href = "#";
        
        var starIcon = document.createElement("i");
        starIcon.className = "fa fa-star";
        
        starLink.appendChild(starIcon);
        starsDiv.appendChild(starLink);
    }
    // End of rating generation
    
    var rowDiv = document.createElement("div");
    rowDiv.className = "row";
    
    var col1Div = document.createElement("div");
    col1Div.className = "col";
    
    var cookLink = document.createElement("a");
    cookLink.href = "recipes_details.php?recipe=" + recipe.Id;
    cookLink.className = "btn";
    cookLink.textContent = "Let's Cook!";
    
    var col2Div = document.createElement("div");
    col2Div.className = "col";
    
    var reviewLink = document.createElement("a");
    reviewLink.href = "review.php?recipe=" + recipe.Id;
    reviewLink.className = "btn";
    reviewLink.textContent = "Add review!";
    
    var downloadLink = document.createElement("a");
    downloadLink.href = "generatePdf.php?recipe=" + recipe.Id;
    downloadLink.className = "btn download";
    
    var downloadIcon = document.createElement("i");
    downloadIcon.className = "fa fa-download";
    
    downloadLink.appendChild(downloadIcon);
    downloadLink.textContent = " Download PDF";
    
    // Append elements
    heartLink.appendChild(heartIcon);
    iconDiv.appendChild(heartLink);
    headerDiv.appendChild(img);
    headerDiv.appendChild(iconDiv);
    cardDiv.appendChild(headerDiv);
    
    foodHeader.appendChild(timeIcon);
    foodHeader.appendChild(servesIcon);
    textDiv.appendChild(foodHeader);
    textDiv.appendChild(starsDiv);
    cardDiv.appendChild(textDiv);
    
    col1Div.appendChild(cookLink);
    col2Div.appendChild(reviewLink);
    rowDiv.appendChild(col1Div);
    rowDiv.appendChild(col2Div);
    cardDiv.appendChild(rowDiv);
    
    cardDiv.appendChild(downloadLink);
    
    // Append the card to a container element in the DOM
    searchResult.appendChild(cardDiv);
}

