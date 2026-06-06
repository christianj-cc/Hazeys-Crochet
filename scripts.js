console.log("Testing if script is loaded!");

document.addEventListener("DOMContentLoaded", function () {
  setupFilterProducts();
  setupUserAuthModal();
  setupImageModal();
  setupAddCartSignInModal();
});

// ---------- FILTER PRODUCTS ----------
function setupFilterProducts() {
  const buttons = document.querySelectorAll('.filter-area button');

  buttons.forEach(button => {
      button.addEventListener("click", function (event) {
          const category = event.target.getAttribute('data-category');
          filterProducts(category);
          buttons.forEach(btn => btn.classList.remove('active'));
          event.target.classList.add('active');
      });
  });
}

function filterProducts(category) {
  let cards = document.querySelectorAll('.card');

  cards.forEach(card => {
      let cardCategories = card.getAttribute('data-category').toLowerCase().split(" "); // Convert to array

      if (category === 'all' || cardCategories.includes(category.toLowerCase())) {
          card.style.display = 'block'; // Show matching products
      } else {
          card.style.display = 'none'; // Hide non-matching products
      }
  });
}


//--------------- FILTER PRODUCT REVIEWS ------------------
function filterProductReviews(productId) {
    let cards = document.querySelectorAll(".card");

    console.log("Filtering for:", productId); // Debugging

    cards.forEach(card => {
        let id = card.getAttribute("data-product-id");
        let reviewSection = card.querySelector(".review-section");
        let seeMoreButton = card.querySelector(".button-seeMore");
        let backButton = card.querySelector(".button-back"); // Get the "Back to Reviews" button

        if (productId === "all") {
            // Reset all products
            card.style.display = "flex";
            reviewSection.style.maxHeight = "100px";  
            reviewSection.classList.remove("expanded"); 
            seeMoreButton.style.display = "block"; 
            backButton.classList.add("hidden"); // Hide Back to Reviews
        } 
        else if (id === productId) {
            // Expand the selected product
            card.style.display = "flex";
            reviewSection.style.maxHeight = "none";  
            reviewSection.classList.add("expanded"); 
            seeMoreButton.style.display = "none"; 
            backButton.classList.remove("hidden"); // Show Back to Reviews
        } 
        else {
            card.style.display = "none"; 
        }
    });
}




// ---------- USERS MODAL ----------
function setupUserAuthModal() {
  const userModal = document.getElementById("usersModal");
  const cartIcon = document.querySelector(".fa-shopping-cart");
  const userIcon = document.querySelector(".fa-user");
  const modalContent = document.querySelector(".users-modalContent");

  // Fetch authentication status from PHP
  const isLoggedIn = JSON.parse(document.getElementById("isLoggedInData").textContent);
  const isAdmin = JSON.parse(document.getElementById("isAdminData").textContent);

  function positionModal(triggerElement) {
      if (userModal.style.display === "block") {
          let rect = triggerElement.getBoundingClientRect();
          let scrollTop = window.scrollY || document.documentElement.scrollTop;

          let modalWidth = userModal.offsetWidth;
          let iconCenter = rect.left + rect.width / 2;
          let modalLeft = iconCenter - modalWidth / 2;

          userModal.style.top = rect.bottom + scrollTop + 10 + "px";
          userModal.style.left = modalLeft + "px";
      }
  }

  function handleIconClick(event, userRedirectURL, adminRedirectURL) {
      event.preventDefault();

      if (isLoggedIn) {
          window.location.href = isAdmin ? adminRedirectURL : userRedirectURL;
      } else {
          if (userModal.style.display === "block") {
            userModal.style.display = "none";
          } else {
              modalContent.style.display = "block";
              userModal.style.display = "block";
              positionModal(event.target);
          }
      }
  }

  cartIcon.addEventListener("click", function(event) {
      handleIconClick(event, "cart.php", "cart.php");
  });

  userIcon.addEventListener("click", function(event) {
      handleIconClick(event, "user.php", "admin.php");
  });

  window.addEventListener("resize", function() {
      if (userModal.style.display === "block") {
          positionModal(cartIcon);
      }
  });
}

// ---------- IMAGE MODAL ----------
function setupImageModal() {
  const imageModal = document.getElementById("imageModal");
  const fullImage = document.getElementById("fullImage");
  const images = document.querySelectorAll(".clickable-img");
  const closeModal = document.querySelector("#imageModal .close");

  images.forEach(img => {
      img.addEventListener("click", function() {
        imageModal.style.display = "block";
          fullImage.src = this.src;
      });
  });

  closeModal.addEventListener("click", function() {
    imageModal.style.display = "none";
  });

  window.addEventListener("click", function(event) {
      if (event.target === imageModal) {
        imageModal.style.display = "none";
      }
  });
}


// ---------- ADD TO CART - FULL SIGN-IN MODAL ----------
document.addEventListener("DOMContentLoaded", function () {
    console.log("AddToCart SignIn Script Loaded!");

    const signInModal = document.getElementById("signInModal");
    const addToCartButtons = document.querySelectorAll(".button-addToCart");
    const closeModal = document.querySelector("#signInModal .close");

    // Fetch authentication status safely
    let isLoggedIn = false;
    try {
        isLoggedIn = JSON.parse(document.getElementById("isLoggedInData")?.textContent || "false");
    } catch (error) {
        console.error("Error parsing isLoggedInData:", error);
    }

    addToCartButtons.forEach(button => {
        button.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent default behavior to avoid issues
            
            const form = this.closest("form"); // Get the closest form element
            if (!form) {
                console.error("Error: Form not found.");
                return;
            }

            const productIdInput = form.querySelector("input[name='product_id']");
            const productNameInput = form.querySelector("input[name='product_name']");

            if (!productIdInput || !productNameInput) {
                console.error("Error: Product ID or Name input is missing.");
                return;
            }

            const productId = productIdInput.value;
            const productName = productNameInput.value;

            if (!isLoggedIn) {
                console.log("User is not logged in. Showing modal.");
                signInModal.style.display = "block";
            } else {
                console.log(`User is logged in. Adding Product to Cart: ID = ${productId}, Name = ${productName}`);
                
                form.submit(); // ✅ Submit the form directly
                console.log("✅ Form submitted successfully");
            }
        });
    });

    // Close modal when "X" is clicked
    closeModal.addEventListener("click", function () {
        signInModal.style.display = "none";
    });

    // Close modal when clicking outside
    window.addEventListener("click", function (event) {
        if (event.target === signInModal) {
            signInModal.style.display = "none";
        }
    });
});


// ---------- SUBMIT REQUEST - FULL SIGN-IN MODAL ----------
document.addEventListener("DOMContentLoaded", function () {
    console.log("Request Signin Script Loaded!");
    
    const requestModal = document.getElementById("requestModal");
    const submitRequestButton = document.querySelector(".button-submitRequest");
    const closeModal = document.querySelector("#requestModal .close");
  
    // Fetch authentication status from PHP
    const isLoggedIn = JSON.parse(document.getElementById("isLoggedInData").textContent);
  
    submitRequestButton.addEventListener("click", function () {
        const form = this.closest("form"); // Get the closest form element
  
        if (!isLoggedIn) {
            console.log("User is not logged in. Showing modal.");
            requestModal.style.display = "block";
        } else {
            console.log(`User is logged in`);
            form.submit(); // Submit the form directly
        }
    });

  
    closeModal.addEventListener("click", function() {
        requestModal.style.display = "none";
    });
    
    window.addEventListener("click", function(event) {
        if (event.target === requestModal) {
            requestModal.style.display = "none";
        }
    });
});
  
  

// ---------- FULL SIGN-OUT MODAL ----------
document.addEventListener("DOMContentLoaded", function () {
    console.log("JavaScript Loaded!"); 

    // Select elements
    const signOutModal = document.getElementById("signOutModal");
    const logoutButton = document.getElementById("logoutButton");
    const closeModal = document.querySelector("#signOutModal .close");
    const cancelLogout = document.getElementById("cancelLogout");
    const confirmLogout = document.getElementById("confirmLogout");
    const logoutForm = document.getElementById("logoutForm");

    // Check if elements exist
    if (!logoutButton || !signOutModal) {
        console.error("Logout button or modal not found!");
        return; // Stop execution if elements are missing
    }

    // Open modal on logout button click
    logoutButton.addEventListener("click", function () {
        console.log("Logout button clicked! Opening modal.");
        signOutModal.style.display = "block";
    });

    // Close modal when clicking (X)
    closeModal.addEventListener("click", function () {
        console.log("Close button clicked!");
        signOutModal.style.display = "none";
    });

    // Close modal when clicking "Cancel"
    cancelLogout.addEventListener("click", function () {
        console.log("Cancel logout clicked!");
        signOutModal.style.display = "none";
    });

    // Confirm logout → Submit form
    confirmLogout.addEventListener("click", function () {
        console.log("Confirm logout clicked! Submitting form...");
        logoutForm.submit();
    });

    // Close modal when clicking outside
    window.addEventListener("click", function (event) {
        if (event.target === signOutModal) {
            console.log("Clicked outside modal. Closing.");
            signOutModal.style.display = "none";
        }
    });
});



// ---------- SHOW ORDER DETAILS  ----------
document.addEventListener("DOMContentLoaded", function () {
    const chevronIcons = document.querySelectorAll(".toggle-down");
  
    chevronIcons.forEach(icon => {
      icon.addEventListener("click", function () {
        const orderId = this.getAttribute("data-order-id");
        const orderDetails = document.querySelectorAll(`tr.order-details[data-order-id="${orderId}"]`);
  
        orderDetails.forEach(item => item.style.display = item.style.display === "none" ? "table-row" : "none");
  
        // Toggle chevron icon direction
        this.classList.toggle("fa-chevron-down");
        this.classList.toggle("fa-chevron-up");
      });
    });
});


// ---------- SHOW REQUEST DETAILS  ----------
document.addEventListener("DOMContentLoaded", function () {
    const chevronIcons = document.querySelectorAll(".toggle-down");

    chevronIcons.forEach(icon => {
        icon.addEventListener("click", function () {
            const requestId = this.getAttribute("data-request-id");
            const requestDetails = document.querySelectorAll(`tr.request-details[data-request-id="${requestId}"]`);

            requestDetails.forEach(detail => detail.style.display = detail.style.display === "none" ? "table-row" : "none");

            // Toggle chevron icon direction
            this.classList.toggle("fa-chevron-down");
            this.classList.toggle("fa-chevron-up");
        });
    });
});


// ---------- SHOW USER DETAILS  ----------
document.addEventListener("DOMContentLoaded", function () {
    const chevronIcons = document.querySelectorAll(".toggle-down");

    chevronIcons.forEach(icon => {
        icon.addEventListener("click", function () {
            const userId = this.getAttribute("data-user-id");
            const userHeader = document.querySelectorAll(`tr.user-header[data-user-id="${userId}"]`);
            const userDetails = document.querySelectorAll(`tr.user-details[data-user-id="${userId}"]`);

            userHeader.forEach(header => header.style.display = header.style.display === "none" ? "table-row" : "none");
            userDetails.forEach(detail => detail.style.display = detail.style.display === "none" ? "table-row" : "none");

            // Toggle chevron icon direction
            this.classList.toggle("fa-chevron-down");
            this.classList.toggle("fa-chevron-up");
        });
    });
});

  
  
//-----------CHECKOUT FUNCTION-------------- 
document.addEventListener("DOMContentLoaded", function () {
    const checkoutArea = document.getElementById("checkout");
    const checkoutbtn = document.querySelector(".button-checkout");

    checkoutbtn.addEventListener("click", function() {
        if (checkoutArea.style.display == "none") {
            checkoutArea.style.display = "block";
        } else if (checkoutArea.style.display == "block") {
            checkoutArea.style.display = "none";
        }
    });
});


// ---------- PAYMENT METHOD DISPLAY  ----------
document.addEventListener("DOMContentLoaded", function () {
    console.log("Payment method script loaded!");

    const paymentSelect = document.querySelector("select[name='payment']");
    const gcashDiv = document.querySelector(".payment-option.gcash");
    const meetupDiv = document.querySelector(".payment-option.meetup");

    if (!paymentSelect || !gcashDiv || !meetupDiv) {
        console.error("Payment method elements not found!");
        return;
    }

    function togglePaymentOptions() {
        console.log("Selected payment method:", paymentSelect.value); // Debugging output

        if (paymentSelect.value === "GCash") {
            gcashDiv.style.display = "block";
            meetupDiv.style.display = "none";
        } else {
            gcashDiv.style.display = "none";
            meetupDiv.style.display = "block";
        }
    }

    // Call function immediately to set initial state
    togglePaymentOptions();

    // Add event listener for changes
    paymentSelect.addEventListener("change", togglePaymentOptions);
});




//--------------- CART ITEMS COUNT BADGE ------------------
document.addEventListener("DOMContentLoaded", function () {
    console.log("Cart badge script loaded!");
    
    const isLoggedIn = JSON.parse(document.getElementById("isLoggedInData").textContent);
    const cartCountBadge = document.getElementById("cartCountBadge");
    const cartCount = parseInt(cartCountBadge.innerText.trim()) || 0;

    if (isLoggedIn) {
        if (cartCount > 0){
            cartCountBadge.style.display = "block";
        } else {
            cartCountBadge.style.display = "none";
        }
    } else {
        cartCountBadge.style.display = "none";
    }
});


//---------------- QUANTITY BUTTONS -----------------------
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".minus-btn").forEach(button => {
      button.addEventListener("click", function() {
        let input = this.nextElementSibling.nextElementSibling;
        let form = this.closest("form");
        let value = parseInt(input.value);
        if (value > parseInt(input.min)) {
          input.value = value - 1;
          form.submit(); // Automatically submits the form
        }
      });
    });

    document.querySelectorAll(".plus-btn").forEach(button => {
      button.addEventListener("click", function() {
        let input = this.previousElementSibling;
        let form = this.closest("form");
        let value = parseInt(input.value);
        if (value < parseInt(input.max)) {
          input.value = value + 1;
          form.submit(); // Automatically submits the form
        }
      });
    });
  });
  
  
// ---------- FULL ASK CONFIRMATION MODAL ----------
document.addEventListener("DOMContentLoaded", function() {
    const modal = document.getElementById("confirmActionModal");
    const closeModal = document.querySelector(".close");
    const cancelAction = document.querySelector(".cancelAction");
    const confirmAction = document.querySelector(".confirmAction");
    const confirmMessage = modal.querySelector("h3"); // The modal message
    let formToSubmit = null; // Store the form reference

    // Open modal when clicking any button with 'confirmTrigger' class
    document.querySelectorAll(".confirmTrigger").forEach(button => {
        button.addEventListener("click", function(event) {
            event.preventDefault(); // Prevent form submission or link action
            
            formToSubmit = this.closest("form"); // Get the parent form
            const message = this.dataset.message || "Are you sure you want to proceed?"; // Default message
            
            confirmMessage.textContent = message; // Change modal text
            modal.style.display = "block"; // Show modal
        });
    });

    // Confirm action: Submit the stored form
    confirmAction.addEventListener("click", function() {
        if (formToSubmit) {
            console.log("Submitting form:", formToSubmit); // Debugging
            formToSubmit.submit(); // Submit the stored form
        } else {
            console.log("Error: No form found to submit!");
        }
        modal.style.display = "none";
    });

    // Cancel action: Close modal
    [closeModal, cancelAction].forEach(element => {
        element.addEventListener("click", function() {
            modal.style.display = "none";
        });
    });

    // Close modal on background click
    window.addEventListener("click", function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
});


//----------- TOGGLE PRODUCT ACTIVE STATUS ---------------
document.querySelectorAll('.toggle-status').forEach(button => {
    updateButtonColor(button); // Set initial color

    button.addEventListener('click', function () {
        let productId = this.getAttribute('data-id');
        let hiddenInput = document.getElementById('is_active_' + productId);
        
        // Toggle the value
        if (hiddenInput.value == "1") {
            hiddenInput.value = "0";
            this.textContent = "Inactive";
        } else {
            hiddenInput.value = "1";
            this.textContent = "Active";
        }

        // Update button color
        updateButtonColor(this);
    });
});

// Function to change button color based on status
function updateButtonColor(button) {
    if (button.textContent.trim() === "Active") {
        button.style.backgroundColor = "#4ea155";
        button.style.color = "white";
    } else {
        button.style.backgroundColor = "#d45353";
        button.style.color = "white";
    }
}



//--------------- BAR MENU FUNCTION -------------
document.addEventListener("DOMContentLoaded", function () {
    const toggleButton = document.querySelector(".fa-bars");
    const sidebar = document.querySelector(".admin .user-info-nav");
    const mainContent = document.querySelector(".admin .user-info-main");
    const sidebarLinks = sidebar.querySelectorAll("a");
    const sidebarIcons = sidebar.querySelectorAll("i");
    const sidebarSpans = sidebar.querySelectorAll("span");
    const logoutButton = document.getElementById("logoutButton");

    let isCollapsed = sessionStorage.getItem("sidebarCollapsed") === "true";

    function applySidebarState() {
        if (isCollapsed) {
            sidebar.style.width = "6%";
            mainContent.style.width = "100%";
            sidebar.style.textAlign = "center";
            logoutButton.style.padding = "15px";
            sidebarSpans.forEach(span => span.style.display = "none");
            sidebarLinks.forEach(link => link.style.fontSize = "25px");
            sidebarIcons.forEach(icon => icon.style.fontSize = "25px");
        } else {
            sidebar.style.width = "20%";
            mainContent.style.width = "100%";
            sidebar.style.textAlign = "left";
            sidebarSpans.forEach(span => span.style.display = "inline");
            sidebarLinks.forEach(link => link.style.fontSize = "16px");
            sidebarIcons.forEach(icon => icon.style.fontSize = "16px");
        }
    }

    applySidebarState();

    toggleButton.addEventListener("click", function () {
        isCollapsed = !isCollapsed;
        sessionStorage.setItem("sidebarCollapsed", isCollapsed);
        applySidebarState();
    });
});


  







