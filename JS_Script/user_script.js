document.addEventListener("DOMContentLoaded", function () {
    let profile = document.querySelector('.header .flex .profile-detail');
    let searchForm = document.querySelector('.header .flex .search-form');
    let navbar = document.querySelector('.navbar');
    let timerElement = document.getElementById("timer");

    //Toggle Profile Section
    document.querySelector('#user-btn')?.addEventListener("click", () => {
        profile?.classList.toggle('active');
        searchForm?.classList.remove('active');
    });

    //Toggle Search Bar
    document.querySelector('#search-btn')?.addEventListener("click", () => {
        searchForm?.classList.toggle('active');
        profile?.classList.remove('active');
    });

    //Toggle Navbar
    document.querySelector('#menu-btn')?.addEventListener("click", () => {
        navbar?.classList.toggle('active');
    });

    // === CART FUNCTIONALITY STARTS === //

    const masterCheckbox = document.querySelector('.select .item-select');
    const itemCheckboxes = document.querySelectorAll('.cart-item .item-select');
    const totalDisplay = document.querySelector('.cart-summary h2');

    // Recalculate total based on selected items
    function calculateSelectedTotal() {
        let total = 0;
        document.querySelectorAll('.cart-item').forEach((item) => {
            const checkbox = item.querySelector('.item-select');
            if (checkbox.checked) {
                const subtotalText = item.querySelector('.cart-item-bottom .left-side').innerText;
                const subtotal = parseFloat(subtotalText.replace('R', '').replace(',', ''));
                if (!isNaN(subtotal)) {
                    total += subtotal;
                }
            }
        });

        totalDisplay.innerHTML = `Total: R${total.toFixed(2)}`;
    }

    // Master select/deselect all items
    masterCheckbox?.addEventListener('change', function () {
        itemCheckboxes.forEach(checkbox => {
            checkbox.checked = masterCheckbox.checked;
        });
        calculateSelectedTotal();
    });

    // Update total when an item is selected or deselected
    itemCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            if (!checkbox.checked) {
                masterCheckbox.checked = false;
            } else if ([...itemCheckboxes].every(cb => cb.checked)) {
                masterCheckbox.checked = true;
            }
            calculateSelectedTotal();
        });
    });

    // Initial calculation on page load
    calculateSelectedTotal();

    // === CART FUNCTIONALITY ENDS === //

    //Countdown Timer for Weekly Deals
    function startCountdown(durationInDays) {
        if (!timerElement) {
            console.error("Timer element #timer not found in the HTML.");
            return;
        }

        let storedTime = localStorage.getItem("countdownEndTime");

        if (!storedTime) {
            let countDownDate = new Date().getTime() + durationInDays * 24 * 60 * 60 * 1000;
            localStorage.setItem("countdownEndTime", countDownDate);
            storedTime = countDownDate;
        }

        let timer = setInterval(function () {
            let now = new Date().getTime();
            let timeLeft = storedTime - now;

            if (timeLeft <= 0) {
                clearInterval(timer);
                timerElement.innerHTML = "EXPIRED";
                localStorage.removeItem("countdownEndTime");
                return;
            }

            let days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
            let hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

            let countdownText = `${days}d ${hours}h ${minutes}m ${seconds}s`;
            timerElement.innerHTML = countdownText;
        }, 1000);
    }

    // Start countdown for 7 days
    startCountdown(7);
});
