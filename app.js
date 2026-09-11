(function () {
    'use strict';

    var translations = {
        uz: {
            registerTitle: "Ro'yxatdan o'tish",
            username: "Foydalanuvchi nomi",
            usernameOrPhone: "Foydalanuvchi nomi yoki telefon raqami",
            back: "Orqaga",
            phone: "Telefon raqami",
            phoneIncomplete: "Telefon raqamini to'liq kiriting: +998 dan keyin 9 ta raqam kerak.",
            password: "Parol",
            register: "Ro'yxatdan o'tish",
            loginPrompt: "Akkauntingiz bormi?",
            loginLink: "Kirish",
            loginTitle: "Tizimga kirish",
            login: "Kirish",
            registerPrompt: "Akkauntingiz yo'qmi?",
            registerLink: "Ro'yxatdan o'tish",
            dashboardTitle: "Dorixona boshqaruvi",
            addProduct: "Dori qo'shish",
            viewProducts: "Dorilarni ko'rish",
            sellProduct: "Dori sotish",
            logout: "Chiqish",
            theme: "Mavzu",
            language: "Til",
            productName: "Dori nomi",
            price: "Narxi (so'm)",
            quantity: "Miqdori",
            add: "Qo'shish",
            sell: "Sotish",
            productList: "Dorilar ro'yxati",
            available: "mavjud"
            ,addTitle: "Dori qo'shish"
            ,sellTitle: "Dori sotish"
            ,name: "Dori nomi"
            ,priceLabel: "Narxi (so'm)"
            ,quantityLabel: "Miqdori"
            ,addButton: "Qo'shish"
            ,sellButton: "Sotish"
            ,productsTitle: "Dorilar ro'yxati"
            ,productHeader: "Dori nomi"
            ,priceHeader: "Narxi (so'm)"
            ,quantityHeader: "Miqdori"
        },
        ru: {
            registerTitle: "Регистрация",
            username: "Имя пользователя",
            usernameOrPhone: "Имя пользователя или номер телефона",
            back: "Назад",
            phone: "Номер телефона",
            phoneIncomplete: "Введите полный номер: после +998 необходимо 9 цифр.",
            password: "Пароль",
            register: "Зарегистрироваться",
            loginPrompt: "Уже есть аккаунт?",
            loginLink: "Войти",
            loginTitle: "Вход в систему",
            login: "Войти",
            registerPrompt: "Нет аккаунта?",
            registerLink: "Зарегистрироваться",
            dashboardTitle: "Управление аптекой",
            addProduct: "Добавить лекарство",
            viewProducts: "Список лекарств",
            sellProduct: "Продать лекарство",
            logout: "Выйти",
            theme: "Тема",
            language: "Язык",
            productName: "Название лекарства",
            price: "Цена (сум)",
            quantity: "Количество",
            add: "Добавить",
            sell: "Продать",
            productList: "Список лекарств",
            available: "доступно"
            ,addTitle: "Добавить лекарство"
            ,sellTitle: "Продажа лекарства"
            ,name: "Название лекарства"
            ,priceLabel: "Цена (сум)"
            ,quantityLabel: "Количество"
            ,addButton: "Добавить"
            ,sellButton: "Продать"
            ,productsTitle: "Список лекарств"
            ,productHeader: "Название лекарства"
            ,priceHeader: "Цена (сум)"
            ,quantityHeader: "Количество"
        },
        en: {
            registerTitle: "Create account",
            username: "Username",
            usernameOrPhone: "Username or phone number",
            back: "Back",
            phone: "Phone number",
            phoneIncomplete: "Enter the complete number: 9 digits are required after +998.",
            password: "Password",
            register: "Register",
            loginPrompt: "Already have an account?",
            loginLink: "Sign in",
            loginTitle: "Sign in",
            login: "Sign in",
            registerPrompt: "Don't have an account?",
            registerLink: "Register",
            dashboardTitle: "Pharmacy management",
            addProduct: "Add medicine",
            viewProducts: "View medicines",
            sellProduct: "Sell medicine",
            logout: "Log out",
            theme: "Theme",
            language: "Language",
            productName: "Medicine name",
            price: "Price (sum)",
            quantity: "Quantity",
            add: "Add",
            sell: "Sell",
            productList: "Medicine list",
            available: "available"
            ,addTitle: "Add medicine"
            ,sellTitle: "Sell medicine"
            ,name: "Medicine name"
            ,priceLabel: "Price (sum)"
            ,quantityLabel: "Quantity"
            ,addButton: "Add"
            ,sellButton: "Sell"
            ,productsTitle: "Medicine list"
            ,productHeader: "Medicine name"
            ,priceHeader: "Price (sum)"
            ,quantityHeader: "Quantity"
        }
    };

    function applyLanguage(language) {
        var dictionary = translations[language] || translations.uz;
        document.documentElement.lang = language;
        document.querySelectorAll('[data-i18n]').forEach(function (element) {
            var key = element.getAttribute('data-i18n');
            if (dictionary[key]) {
                element.textContent = dictionary[key];
            }
        });
        document.querySelectorAll('[data-i18n-placeholder]').forEach(function (element) {
            var key = element.getAttribute('data-i18n-placeholder');
            if (dictionary[key]) {
                element.placeholder = dictionary[key];
            }
        });
        localStorage.setItem('pharmacy-language', language);
        var selector = document.getElementById('languageSelect');
        if (selector) {
            selector.value = language;
        }
    }

    function formatPhone(input) {
        var digits = input.value.replace(/\D/g, '');
        if (digits.indexOf('998') === 0) {
            digits = digits.slice(3);
        }
        digits = digits.slice(0, 9);
        var formatted = '+998';
        if (digits.length > 0) formatted += ' ' + digits.slice(0, 2);
        if (digits.length > 2) formatted += ' ' + digits.slice(2, 5);
        if (digits.length > 5) formatted += ' ' + digits.slice(5, 7);
        if (digits.length > 7) formatted += ' ' + digits.slice(7, 9);
        input.value = formatted;
    }

    document.addEventListener('DOMContentLoaded', function () {
        var savedLanguage = localStorage.getItem('pharmacy-language') || 'uz';
        applyLanguage(savedLanguage);

        var languageSelect = document.getElementById('languageSelect');
        if (languageSelect) {
            languageSelect.addEventListener('change', function () {
                applyLanguage(languageSelect.value);
            });
        }

        var themeToggle = document.getElementById('themeToggle');
        var deviceTheme = window.matchMedia('(prefers-color-scheme: dark)');
        var savedTheme = localStorage.getItem('pharmacy-theme');

        function setTheme(isDark) {
            document.body.classList.toggle('dark-theme', isDark);
            if (themeToggle) {
                themeToggle.textContent = isDark ? '☀' : '☾';
                themeToggle.title = isDark ? 'Light mode ga o\'tish' : 'Dark mode ga o\'tish';
            }
        }

        function syncDeviceTheme() {
            setTheme(savedTheme === 'dark' || (savedTheme !== 'light' && deviceTheme.matches));
        }

        syncDeviceTheme();
        if (deviceTheme.addEventListener) {
            deviceTheme.addEventListener('change', syncDeviceTheme);
        } else {
            deviceTheme.addListener(syncDeviceTheme);
        }
        if (themeToggle) {
            themeToggle.addEventListener('click', function () {
                var isDark = !document.body.classList.contains('dark-theme');
                savedTheme = isDark ? 'dark' : 'light';
                localStorage.setItem('pharmacy-theme', savedTheme);
                setTheme(isDark);
            });
        }

        var navToggle = document.getElementById('navToggle');
        var sidebar = document.getElementById('sidebar');
        if (navToggle && sidebar) {
            navToggle.addEventListener('click', function () {
                sidebar.classList.toggle('open');
            });
            sidebar.querySelectorAll('a').forEach(function (link) {
                link.addEventListener('click', function () {
                    sidebar.classList.remove('open');
                });
            });
        }

        document.querySelectorAll('input[data-phone]').forEach(function (input) {
            if (input.value) formatPhone(input);
            input.addEventListener('focus', function () {
                if (!input.value) input.value = '+998 ';
            });
            input.addEventListener('input', function () {
                formatPhone(input);
            });
        });

        document.querySelectorAll('form').forEach(function (form) {
            form.addEventListener('submit', function (event) {
                var phone = form.querySelector('input[data-phone]');
                if (phone) {
                    var digits = phone.value.replace(/\D/g, '');
                    var localDigits = digits.indexOf('998') === 0 ? digits.slice(3) : digits;
                    var error = form.querySelector('[data-phone-error]');

                    if (localDigits.length !== 9) {
                        if (error) {
                            error.textContent = (translations[localStorage.getItem('pharmacy-language') || 'uz'] || translations.uz).phoneIncomplete;
                            error.hidden = false;
                        }
                        phone.setAttribute('aria-invalid', 'true');
                        phone.focus();
                        event.preventDefault();
                        return;
                    }

                    if (error) {
                        error.hidden = true;
                    }
                    phone.removeAttribute('aria-invalid');
                    phone.value = localDigits;
                }
            });
        });
    });
})();
