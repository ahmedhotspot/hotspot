/**
 * Hotspot Finance Revamp - Main JS
 */

document.addEventListener("DOMContentLoaded", () => {

  // ==========================================
  // 1. Navbar Scroll Effect
  // ==========================================
  const navbar = document.getElementById("navbar");

  window.addEventListener("scroll", () => {
    if (!navbar) return;
    if (window.scrollY > 50) {
      navbar.style.background = "rgba(255, 255, 255, 0.98)";
      navbar.style.boxShadow = "var(--shadow-sm)";
    } else {
      navbar.style.background = "rgba(255, 255, 255, 0.9)";
      navbar.style.boxShadow = "none";
    }
  });

    // 2. Interactive Calculator Logic
    const amountSlider = document.getElementById('slider-amount');
    const yearsSlider = document.getElementById('slider-years');

    if (amountSlider && yearsSlider) {
        const amountVal = document.getElementById('val-amount');
        const yearsVal = document.getElementById('val-years');
        const resMonthly = document.getElementById('res-monthly');
        const resTotal = document.getElementById('res-total');
        const tabBtns = document.querySelectorAll('.tab-btn');

        let currentRate = 0.0299; // Default 2.99% for Personal Look

        // Formatting numbers with commas
        const formatNumber = (num) => {
            return num.toLocaleString('en-US');
        };

        const calculate = () => {
            const amount = parseFloat(amountSlider.value);
            const years = parseFloat(yearsSlider.value);
            const months = years * 12;

            // Simple Interest Calculation for demo purposes
            const totalInterest = amount * currentRate * years;
            const totalAmount = amount + totalInterest;
            const monthlyPayment = totalAmount / months;

            // Update UI
            if(amountVal) amountVal.innerText = formatNumber(amount);
            if(yearsVal) yearsVal.innerText = years;
            if(resMonthly) resMonthly.innerText = formatNumber(Math.round(monthlyPayment)) + ' SAR';
            if(resTotal) resTotal.innerText = formatNumber(Math.round(totalAmount)) + ' SAR';
        };

        // Tab Logic (Changes rates for different types)
        tabBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                tabBtns.forEach(b => b.classList.remove('active'));
                e.currentTarget.classList.add('active');

                const type = e.currentTarget.dataset.type;
                const aprText = document.getElementById('res-apr');
                if(type === 'personal') { currentRate = 0.0299; if(aprText) aprText.innerText = '2.99%'; }
                if(type === 'auto') { currentRate = 0.045; if(aprText) aprText.innerText = '4.50%'; }
                if(type === 'mortgage') { currentRate = 0.052; if(aprText) aprText.innerText = '5.20%'; }

                calculate();
            });
        });

        amountSlider.addEventListener('input', calculate);
        yearsSlider.addEventListener('input', calculate);

        // Initial Calculate
        calculate();
    }

    // 3. FAQ Accordion
    const faqQuestions = document.querySelectorAll('.faq-question');
    faqQuestions.forEach(btn => {
        btn.addEventListener('click', () => {
            const item = btn.parentElement;
            const isActive = item.classList.contains('active');

            // Close all items in the same category
            const category = item.closest('.faq-list');
            category.querySelectorAll('.faq-item.active').forEach(openItem => {
                openItem.classList.remove('active');
            });

            // Toggle clicked item
            if (!isActive) {
                item.classList.add('active');
            }
        });
    });

    // 4. Mobile Menu Toggle
    const mobileMenuBtn = document.querySelector(".mobile-menu-btn");

    if (mobileMenuBtn) {
        const mobileMenuIcon = mobileMenuBtn.querySelector("i");

        mobileMenuBtn.addEventListener("click", () => {
            navbar.classList.toggle("nav-open");

            // Toggle icon between bars and xmark
            if (navbar.classList.contains("nav-open")) {
                if(mobileMenuIcon) {
                    mobileMenuIcon.classList.remove("fa-bars");
                    mobileMenuIcon.classList.add("fa-xmark");
                }
            } else {
                if(mobileMenuIcon) {
                    mobileMenuIcon.classList.remove("fa-xmark");
                    mobileMenuIcon.classList.add("fa-bars");
                }
            }
        });
    }
});
