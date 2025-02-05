// Slideshow

let slideIndex = 0;
showSlides();

function showSlides() {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");

    // Hide all slides
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";  
    }

    slideIndex++;

    // Loop back to the first slide if we go past the last
    if (slideIndex > slides.length) {
        slideIndex = 1;
    }

    // Remove active class from all dots
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }

    // Show the current slide and set the active dot
    slides[slideIndex - 1].style.display = "block";  
    dots[slideIndex - 1].className += " active";
    
    // Change slide every 3 seconds
    setTimeout(showSlides, 3000);
}

function plusSlides(n) {
    slideIndex += n;  // Adjusted to directly add n
    let slides = document.getElementsByClassName("mySlides"); // Moved here to avoid reference issues

    // Loop back if exceeding the number of slides
    if (slideIndex > slides.length) {
        slideIndex = 1;
    } else if (slideIndex < 1) {
        slideIndex = slides.length; // Wrap to last slide
    }

    showSlidesManual(slideIndex);
}

function currentSlide(n) {
    showSlidesManual(slideIndex = n);
}

function showSlidesManual(n) {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");

    // Hide all slides
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";  
    }

    // Remove active class from all dots
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }

    // Show the current slide and set the active dot
    slides[n - 1].style.display = "block";  
    dots[n - 1].className += " active";
}

// form

document.addEventListener("DOMContentLoaded", () => {
    generateCaptcha(); // Generate a new CAPTCHA on page load

    const form = document.getElementById("vinForm");
    form.addEventListener("submit", (event) => {
        event.preventDefault(); // Prevent default form submission behavior
        if (validateForm()) {
            redirectToPage();
        }
    });
});

// Redirect to car_info.html with the VIN number as a query parameter
function redirectToPage() {
    const vin = document.getElementById('vin').value;

    // Validate VIN length
    if (vin && vin.length === 17) {
        localStorage.setItem('VIN', vin); // Save VIN to local storage
        window.location.href = `car_info.html?vin=${encodeURIComponent(vin)}`; // Redirect
    } else {
        alert('Please enter a valid 17-character VIN.');
    }
}

// Generate a random CAPTCHA question
function generateCaptcha() {
    const num1 = Math.floor(Math.random() * 10);
    const num2 = Math.floor(Math.random() * 10);
    const question = `What is ${num1} + ${num2}?`;

    document.getElementById("captchaQuestion").innerText = question;
    document.getElementById("captchaQuestion").setAttribute("data-answer", num1 + num2);
}

// Validate the form input (VIN and CAPTCHA)
function validateForm() {
    const vin = document.getElementById("vin").value;
    const answer = document.getElementById("captchaAnswer").value;
    const correctAnswer = document.getElementById("captchaQuestion").getAttribute("data-answer");

    const vinPattern = /^[A-HJ-NPR-Z0-9]{17}$/; // Basic VIN pattern, excludes invalid characters
    if (!vinPattern.test(vin)) {
        alert("Please enter a valid 17-character VIN.");
        return false;
    }

    if (parseInt(answer) !== parseInt(correctAnswer)) {
        alert("Incorrect CAPTCHA. Please try again.");
        generateCaptcha(); // Regenerate CAPTCHA on failure
        return false;
    }

    return true; // Form is valid
}

// Ratings
let selectedRating = 0;

// Star hover and click events
document.querySelectorAll('.star').forEach(star => {
    star.addEventListener('mouseover', () => {
        resetStars();
        fillStars(star.getAttribute('data-value'));
    });

    star.addEventListener('mouseout', () => {
        resetStars();
        if (selectedRating !== 0) {
            fillStars(selectedRating);
        }
    });

    star.addEventListener('click', () => {
        selectedRating = star.getAttribute('data-value');
        fillStars(selectedRating);
    });
});

// Fill stars based on rating
function fillStars(rating) {
    document.querySelectorAll('.star').forEach(star => {
        if (star.getAttribute('data-value') <= rating) {
            star.classList.add('filled');
        }
    });
}

// Reset all stars to unfilled
function resetStars() {
    document.querySelectorAll('.star').forEach(star => {
        star.classList.remove('filled');
    });
}

// Submit review and add it to the review section
function submitReview() {
    const name = document.getElementById('name').value;
    const comment = document.getElementById('comment').value;

    if (selectedRating && name && comment) {
        const reviewSection = document.querySelector('.customer-reviews');
        const newReview = document.createElement('div');
        newReview.classList.add('review-box');

        newReview.innerHTML = `<p class="reviewer-name">${name}</p><p class="review-text">"${comment}"</p>`;
        
        // Prepend new review and reset the form
        reviewSection.prepend(newReview);
        document.getElementById('ratingForm').reset();
        selectedRating = 0;
        resetStars();
        alert('Your review has been submitted!');

        // Add fading animation
        setTimeout(() => {
            newReview.classList.add('visible'); // Trigger fade-in
        }, 10); // Delay to allow the browser to register the element

        // Show extra reviews if the limit is reached
        limitReviews();
    } else {
        alert('Please provide a name, rating, and a comment.');
    }
}

// Toggle visibility of extra reviews
function toggleReviews() {
    const extraReviews = document.querySelector('.extra-reviews');
    const toggleBtn = document.getElementById('toggleReviewsBtn');

    if (extraReviews.style.display === 'none') {
        extraReviews.style.display = 'block';
        toggleBtn.textContent = 'Show Less';
    } else {
        extraReviews.style.display = 'none';
        toggleBtn.textContent = 'Show More';
    }
}

// Limit visible reviews to three initially
function limitReviews() {
    const reviews = document.querySelectorAll('.review-box');
    const toggleBtn = document.getElementById('toggleReviewsBtn');

    reviews.forEach((review, index) => {
        review.style.display = index < 4 ? 'block' : 'none';
    });

    // Show toggle button if there are more than three reviews
    toggleBtn.style.display = reviews.length > 4 ? 'block' : 'none';
}

// Initial setup on page load
limitReviews();

// Slide-in animation when section is in view
document.addEventListener("DOMContentLoaded", () => {
    const ratingsSection = document.querySelector('.ratings-section');

    if (ratingsSection) {
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    ratingsSection.classList.add('show');  // Add class when section in view
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        observer.observe(ratingsSection);
    }
});

// return confirmation alert

    // Check if it's the user's first visit during this session
    if (!sessionStorage.getItem('firstPage')) {
        sessionStorage.setItem('firstPage', window.location.href); // Set the first page URL
    }

    // Detect when the user is about to leave
    window.addEventListener('beforeunload', function (event) {
        const firstPage = sessionStorage.getItem('firstPage'); // Get the first page
        const currentUrl = window.location.href; // Current page URL

        // Show the alert only if:
        // 1. The user is leaving the first page
        // 2. The back button would navigate away from the site (not to another internal page)
        if (currentUrl === firstPage && document.referrer && !document.referrer.includes(window.location.hostname)) {
            // Customize the message
            event.preventDefault();
            event.returnValue = 'Are you sure you want to leave? You might miss important insights!';
            return 'Are you sure you want to leave?';
        }
    });


