// Main JavaScript for CoinStoreBD

// Order shofol hole success modal dekhano
window.showSuccessModal = (message, title = 'Success!') => {
    const modal = document.getElementById('successModal');
    const msgEl = document.getElementById('successMessage');
    const titleEl = document.getElementById('successTitle');
    
    if (modal && msgEl && titleEl) {
        titleEl.textContent = title;
        msgEl.textContent = message;
        modal.style.display = 'block';
    }
};

// Form validation ba error hole error modal dekhano
window.showErrorModal = (message, title = 'Validation Error') => {
    const statusResult = document.getElementById('statusResult');
    const statusModal = document.getElementById('statusModal');
    if (statusResult && statusModal) {
        statusResult.innerHTML = `
            <div class="status-error" style="text-align: center; padding: 1rem;">
                <div style="width: 60px; height: 60px; background: #ffebee; color: #e74c3c; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 1.5rem; border: 3px solid #e74c3c; animation: shake 0.5s ease-in-out;">
                    ✕
                </div>
                <h3 style="color: var(--secondary-color); margin-bottom: 0.5rem; font-family: 'Playfair Display', serif;">${title}</h3>
                <p style="color: #666; line-height: 1.5;">${message}</p>
                <button onclick="document.getElementById('statusModal').style.display='none'" class="btn" style="margin-top: 1.5rem; width: 100%; background: #e74c3c; color: white; border: none; border-radius: 8px; padding: 0.8rem;">Try Again</button>
            </div>`;
        statusModal.style.display = 'block';
    } else {
        alert(message);
    }
};

// Success modal bondho kora ebong URL theke success parameters muche fela
window.closeSuccessModal = () => {
    const modal = document.getElementById('successModal');
    if (modal) {
        modal.style.display = 'none';
        const url = new URL(window.location);
        url.searchParams.delete('success');
        url.searchParams.delete('message');
        url.searchParams.delete('title');
        window.history.replaceState({}, document.title, url.pathname);
    }
};

document.addEventListener('DOMContentLoaded', () => {
    // Page load hoyar por URL-e success message ache kina check kora
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('success')) {
        const msg = urlParams.get('message') || 'Action completed successfully!';
        const title = urlParams.get('title') || 'Success!';
        showSuccessModal(msg, title);
    }
    
    // Mobile-e hamburger menu khola ba bondho kora
    const mobileMenu = document.getElementById('mobile-menu');
    const navMenu = document.getElementById('nav-menu');
    const navClose = document.getElementById('nav-close');

    if (mobileMenu && navMenu) {
        mobileMenu.addEventListener('click', () => {
            navMenu.classList.add('active'); // Menu show kora
        });
    }

    if (navClose && navMenu) {
        navClose.addEventListener('click', () => {
            navMenu.classList.remove('active'); // Menu hide kora
        });
    }

    // Menu-r baire click korle menu bondho kora
    window.addEventListener('click', (e) => {
        if (navMenu && navMenu.classList.contains('active') && 
            !navMenu.contains(e.target) && 
            !mobileMenu.contains(e.target)) {
            navMenu.classList.remove('active');
        }
    });

    // Menu link click korle menu bondho kora (on-page navigation er jonno)
    const navLinks = navMenu ? navMenu.querySelectorAll('ul li a') : [];
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (navMenu) navMenu.classList.remove('active');
        });
    });

    // Main tabs (Promote, GetCoin, Business) switch korar logic
    const tabItems = document.querySelectorAll('.tab-item');
    const welcomeMessage = document.getElementById('welcome-message');
    
    const sections = {
        'promote': document.getElementById('promote-section'),
        'getcoin': document.getElementById('getcoin-section'),
        'business': document.getElementById('business-section')
    };

    tabItems.forEach(item => {
        item.addEventListener('click', (e) => {
            const targetTab = item.getAttribute('data-tab');
            
            // Check if we are on index.php (if sections exist)
            if (sections[targetTab]) {
                e.preventDefault();
                tabItems.forEach(i => i.classList.remove('active'));
                item.classList.add('active');

                if (welcomeMessage) welcomeMessage.style.display = 'none';

                Object.values(sections).forEach(section => {
                    if (section) section.style.display = 'none';
                });

                sections[targetTab].style.display = 'block';
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });
    });

    // URL parameter thakle auto shei tab-e switch kora
    const activeTabParam = urlParams.get('tab');
    if (activeTabParam && sections[activeTabParam]) {
        const targetTabItem = document.querySelector(`.tab-item[data-tab="${activeTabParam}"]`);
        if (targetTabItem) targetTabItem.click();
    }

    // FAQ proshno gulo toggle (accordion) kora
    const faqQuestions = document.querySelectorAll('.faq-question');
    faqQuestions.forEach(q => {
        q.addEventListener('click', () => {
            const item = q.parentElement;
            document.querySelectorAll('.faq-item').forEach(i => {
                if (i !== item) i.classList.remove('active'); // Onno gulo bondho kora
            });
            item.classList.toggle('active');
        });
    });

    // Promote form-e বাজেট অনুযায়ী আনুমানিক ভিউ/লাইক হিসাব করা
    const priceInput = document.getElementById('price');
    const categorySelect = document.getElementById('category');
    const estimatedResult = document.getElementById('estimated-result');
    const plusBtn = document.getElementById('plus-btn');
    const minusBtn = document.getElementById('minus-btn');

    if (priceInput && categorySelect && estimatedResult) {
        const updateEstimate = () => {
            const budget = parseFloat(priceInput.value) || 0;
            const type = categorySelect.value;
            const typeKey = type.toLowerCase();
            
            // HTML theke translated shobdo gulo nawa
            const estimatedStr = estimatedResult.getAttribute('data-estimated') || 'Estimated';
            const viewsStr = estimatedResult.getAttribute('data-views') || 'Views';
            const likesStr = estimatedResult.getAttribute('data-likes') || 'Likes';
            const commentsStr = estimatedResult.getAttribute('data-comments') || 'Comments';
            const followersStr = estimatedResult.getAttribute('data-followers') || 'Followers';
            
            // Get dynamic rates from data attributes (Admin theke set kora)
            const viewRate = parseFloat(estimatedResult.getAttribute(`data-rate-${typeKey}-views`)) || 0;
            const likeRate = parseFloat(estimatedResult.getAttribute(`data-rate-${typeKey}-likes`)) || 0;
            const commentRate = parseFloat(estimatedResult.getAttribute(`data-rate-${typeKey}-comments`)) || 0;
            const followerRate = parseFloat(estimatedResult.getAttribute(`data-rate-${typeKey}-followers`)) || 0;
            
            let displayValue = '';
            let results = [];

            // বাজেট অনুযায়ী ডাটা ক্যালকুলেশন করা
            if (viewRate > 0) results.push(`${Math.floor(budget * viewRate).toLocaleString()} ${viewsStr}`);
            if (likeRate > 0) results.push(`${Math.floor(budget * likeRate).toLocaleString()} ${likesStr}`);
            if (commentRate > 0) results.push(`${Math.floor(budget * commentRate).toLocaleString()} ${commentsStr}`);
            if (followerRate > 0) results.push(`${Math.floor(budget * followerRate).toLocaleString()} ${followersStr}`);

            displayValue = `${estimatedStr}: ` + results.join(' + ');
            estimatedResult.textContent = displayValue;
        };

        // Budget barano ba komanor buttons (Stepper)
        if (plusBtn && minusBtn) {
            plusBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                let current = parseInt(priceInput.value) || 200;
                priceInput.value = current + 200;
                updateEstimate();
            });

            minusBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                let current = parseInt(priceInput.value) || 200;
                if (current > 200) {
                    priceInput.value = current - 200;
                    updateEstimate();
                }
            });
        }

        categorySelect.addEventListener('change', updateEstimate);
        
        // Initial calculation on load
        updateEstimate();
    }

    // Promote form-e পেমেন্ট মেথড সিলেক্ট করলে এজেন্ট নম্বর দেখানো
    const paymentSelect = document.getElementById('payment_option');
    const agentDisplay = document.getElementById('agent-number-display');
    const agentNumber = document.getElementById('agent-number');
    const paymentMethodName = document.getElementById('payment-method-name');

    if (paymentSelect && agentDisplay && agentNumber && paymentMethodName) {
        paymentSelect.addEventListener('change', () => {
            const selected = paymentSelect.value;
            const agentNumbers = window.dynamicAgentNumbers || {};
            if (selected && agentNumbers[selected]) {
                paymentMethodName.textContent = selected;
                agentNumber.textContent = agentNumbers[selected];
                agentDisplay.style.display = 'block';
            } else {
                agentDisplay.style.display = 'none';
            }
        });
    }

    // GetCoin form-e পেমেন্ট মেথড সিলেক্ট করলে এজেন্ট নম্বর দেখানো
    const getcoinPaymentSelect = document.getElementById('getcoin_payment_option');
    const getcoinAgentDisplay = document.getElementById('getcoin-agent-number-display');
    const getcoinAgentNumber = document.getElementById('getcoin-agent-number');
    const getcoinPaymentMethodName = document.getElementById('getcoin-payment-method-name');

    if (getcoinPaymentSelect && getcoinAgentDisplay && getcoinAgentNumber && getcoinPaymentMethodName) {
        getcoinPaymentSelect.addEventListener('change', () => {
            const selected = getcoinPaymentSelect.value;
            const agentNumbers = window.dynamicAgentNumbers || {};
            if (selected && agentNumbers[selected]) {
                getcoinPaymentMethodName.textContent = selected;
                getcoinAgentNumber.textContent = agentNumbers[selected];
                getcoinAgentDisplay.style.display = 'block';
            } else {
                getcoinAgentDisplay.style.display = 'none';
            }
        });
    }

    // GetCoin form-e কয়েনের পরিমাণ অনুযায়ী মোট টাকা হিসাব করা
    const coinAmountInput = document.getElementById('coin_amount');
    const coinPriceDisplay = document.getElementById('coin-price-display');

    if (coinAmountInput && coinPriceDisplay) {
        coinAmountInput.addEventListener('input', () => {
            const amount = parseFloat(coinAmountInput.value) || 0;
            const rate = 2; // Proti coin 2 taka
            coinPriceDisplay.textContent = `Total Price: ${(amount * rate).toLocaleString()} Taka`;
        });
    }

    // TrxID দিয়ে অর্ডার স্ট্যাটাস সার্চ করার লজিক
    const searchForm = document.getElementById('searchStatusForm');
    const searchInput = document.getElementById('searchTrxID');
    const statusModal = document.getElementById('statusModal');
    const statusResult = document.getElementById('statusResult');
    const closeModal = document.querySelector('.close-modal');

    if (searchForm && searchInput && statusModal && statusResult) {
        searchForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const trxid = searchInput.value.trim();
            if (!trxid) { alert('Please enter a Transaction ID'); return; }

            statusResult.innerHTML = '<div style="text-align:center; padding:2rem;">Searching...</div>';
            statusModal.style.display = 'block';

            fetch(`search_status.php?trxid=${encodeURIComponent(trxid)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        statusResult.innerHTML = data.html;
                        // Pending অর্ডার হলে ১০ মিনিটের টাইমার দেখানো
                        if (data.status === 'pending' || data.status === 'rejected') {
                            const createdAt = new Date(data.created_at).getTime();
                            const now = new Date().getTime();
                            const diffMinutes = Math.floor((now - createdAt) / 1000 / 60);

                            if (data.status === 'pending' && diffMinutes < 10) {
                                const remainingMs = (10 * 60 * 1000) - (now - createdAt);
                                const timerContainer = document.createElement('div');
                                timerContainer.style = 'text-align:center; margin-top:1rem; padding:10px; background:#fff8e1; border-radius:8px; border:1px solid #ffe082;';
                                
                                let timeLeft = Math.floor(remainingMs / 1000);
                                const updateTimerDisplay = () => {
                                    const mins = Math.floor(timeLeft / 60);
                                    const secs = timeLeft % 60;
                                    timerContainer.innerHTML = `<div style="font-size:0.85rem; color:#f39c12; font-weight:bold; margin-bottom:5px;">অর্ডার প্রসেসিং হচ্ছে...</div><div style="font-size:1.2rem; font-weight:bold; color:#d35400;">${mins}:${secs < 10 ? '0' : ''}${secs} অপেক্ষা করুন।</div>`;
                                };
                                updateTimerDisplay();
                                statusResult.appendChild(timerContainer);
                                
                                const timerInterval = setInterval(() => {
                                    if (--timeLeft <= 0) { clearInterval(timerInterval); location.reload(); }
                                    else { updateTimerDisplay(); }
                                }, 1000);

                                closeModal.addEventListener('click', () => clearInterval(timerInterval));
                                window.addEventListener('click', (e) => { if (e.target === statusModal) clearInterval(timerInterval); });
                            } else if (data.status === 'rejected' || (data.status === 'pending' && diffMinutes >= 10)) {
                                // Rejected বা ১০ মিনিট পার হলে WhatsApp সাপোর্ট বাটন দেখানো
                                const whatsappNum = window.supportWhatsApp || "8801845464034";
                                const whatsappBtn = document.createElement('a'); 
                                whatsappBtn.href = "https://wa.me/" + whatsappNum + "?text=" + encodeURIComponent("TrxID: " + trxid + " status check!");
                                whatsappBtn.target = "_blank";
                                whatsappBtn.className = "btn";
                                whatsappBtn.style = "width:100%; margin-top:1rem; background:#25D366; color:white; border:none;";
                                whatsappBtn.innerHTML = "Support (WhatsApp)";
                                statusResult.appendChild(whatsappBtn);
                            }
                        }
                    } else {
                        statusResult.innerHTML = `<div class="status-error"><h3>Not Found</h3><p>${data.message}</p></div>`;
                    }
                })
                .catch(err => { statusResult.innerHTML = '<div class="status-error"><p>An error occurred.</p></div>'; });
        });
    }

    if (closeModal) closeModal.addEventListener('click', () => { statusModal.style.display = 'none'; });
    window.addEventListener('click', (e) => { if (e.target === statusModal) statusModal.style.display = 'none'; });

    // Form submit korar age validation (WhatsApp num, TrxID length, TikTok link check)
    const validateForm = (formId) => {
        const form = document.getElementById(formId);
        if (!form) return true;
        let isValid = true;
        let errorMessage = "";

        const whatsappInput = form.querySelector('input[name="whatsapp"]');
        if (whatsappInput && (whatsappInput.value.trim().length < 11)) {
            isValid = false; errorMessage = "WhatsApp number must be at least 11 digits.";
        }

        const trxInput = form.querySelector('textarea[name="description"]');
        if (isValid && trxInput && (trxInput.value.trim().length < 10 || trxInput.value.trim().length > 15)) {
            isValid = false; errorMessage = "Transaction ID must be 10-15 characters.";
        }

        if (isValid && formId === 'promoteForm') {
            const linkInput = document.getElementById('coin_title');
            const urlRegex = /^(https?:\/\/)?(www\.|vm\.|vt\.|t\.)?tiktok\.com\/.*$/i;
            if (linkInput && !urlRegex.test(linkInput.value.trim())) {
                isValid = false; errorMessage = "Please enter a valid TikTok video link.";
            }
        }

        if (!isValid) showErrorModal(errorMessage);
        return isValid;
    };

    // Duplicate TrxID check kora ebong form submit kora
    const checkAndSubmit = (form, trxInputId) => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (!validateForm(form.id)) return;
            const trxid = document.getElementById(trxInputId).value.trim();
            fetch(`check_duplicate_trxid.php?trxid=${encodeURIComponent(trxid)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.duplicate) showErrorModal("This Transaction ID has already been used.", "Duplicate TrxID");
                    else form.submit();
                })
                .catch(() => form.submit());
        });
    };

    if (document.getElementById('promoteForm')) checkAndSubmit(document.getElementById('promoteForm'), 'promote_trxid');
    if (document.getElementById('getcoinForm')) checkAndSubmit(document.getElementById('getcoinForm'), 'getcoin_trxid');
});
