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
            ,management: "Boshqaruv"
            ,overview: "Umumiy ko'rinish"
            ,inventory: "Inventar"
            ,addMedicine: "Mahsulot qo'shish"
            ,salesWindow: "Sotuv oynasi"
            ,account: "Hisob"
            ,signOut: "Chiqish"
            ,pharmacyManagement: "Dorixona boshqaruvi"
            ,greeting: "Assalomu alaykum,"
            ,todayControl: "Bugungi nazorat"
            ,inventoryInHand: "Inventaringiz qo'lingizda."
            ,inventoryDescription: "Qoldiqni kuzating, yangi mahsulot qo'shing va sotuvni tez yakunlang."
            ,newSale: "Yangi sotuv"
            ,active: "Faol"
            ,total: "Jami"
            ,attention: "E'tibor"
            ,valued: "Baholangan"
            ,productTypes: "Turdagi mahsulotlar"
            ,stockUnits: "Ombordagi birliklar"
            ,lowStock: "Kam qolgan mahsulotlar"
            ,inventoryValue: "Inventar qiymati, so'm"
            ,quickControl: "Tezkor nazorat"
            ,seeAll: "Barchasini ko'rish →"
            ,workflow: "Ish jarayoni"
            ,quickActions: "Tezkor amallar"
            ,restock: "Omborni to'ldiring"
            ,startSale: "Sotuvni boshlash"
            ,completeOrder: "Buyurtmani rasmiylashtiring"
            ,checkInventory: "Barcha qoldiqni tekshiring"
            ,recentInventory: "Inventar"
            ,recentProducts: "So'nggi qo'shilgan mahsulotlar"
            ,newProduct: "+ Yangi mahsulot"
            ,productStatus: "Holat"
            ,statusAvailable: "Mavjud"
            ,statusLow: "Kam qoldi"
            ,units: "dona"
            ,allGood: "Hammasi joyida"
            ,noLowStock: "Kam qolgan mahsulotlar mavjud emas."
            ,left: "qoldi"
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
            ,management: "Управление"
            ,overview: "Обзор"
            ,inventory: "Инвентарь"
            ,addMedicine: "Добавить товар"
            ,salesWindow: "Окно продаж"
            ,account: "Аккаунт"
            ,signOut: "Выйти"
            ,pharmacyManagement: "Управление аптекой"
            ,greeting: "Здравствуйте,"
            ,todayControl: "Контроль на сегодня"
            ,inventoryInHand: "Ваш инвентарь под контролем."
            ,inventoryDescription: "Следите за остатками, добавляйте товары и быстро завершайте продажи."
            ,newSale: "Новая продажа"
            ,active: "Активно"
            ,total: "Всего"
            ,attention: "Внимание"
            ,valued: "Оценено"
            ,productTypes: "Видов товаров"
            ,stockUnits: "Единиц на складе"
            ,lowStock: "Товары с низким остатком"
            ,inventoryValue: "Стоимость инвентаря, сум"
            ,quickControl: "Быстрый контроль"
            ,seeAll: "Посмотреть все →"
            ,workflow: "Рабочий процесс"
            ,quickActions: "Быстрые действия"
            ,restock: "Пополните склад"
            ,startSale: "Начать продажу"
            ,completeOrder: "Оформите заказ"
            ,checkInventory: "Проверьте все остатки"
            ,recentInventory: "Инвентарь"
            ,recentProducts: "Последние добавленные товары"
            ,newProduct: "+ Новый товар"
            ,productStatus: "Статус"
            ,statusAvailable: "В наличии"
            ,statusLow: "Мало осталось"
            ,units: "шт."
            ,allGood: "Всё в порядке"
            ,noLowStock: "Товаров с низким остатком нет."
            ,left: "осталось"
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
            ,management: "Management"
            ,overview: "Overview"
            ,inventory: "Inventory"
            ,addMedicine: "Add product"
            ,salesWindow: "Sales desk"
            ,account: "Account"
            ,signOut: "Sign out"
            ,pharmacyManagement: "Pharmacy management"
            ,greeting: "Welcome,"
            ,todayControl: "Today's control"
            ,inventoryInHand: "Your inventory, at a glance."
            ,inventoryDescription: "Track stock, add products, and complete sales quickly."
            ,newSale: "New sale"
            ,active: "Active"
            ,total: "Total"
            ,attention: "Attention"
            ,valued: "Valued"
            ,productTypes: "Product types"
            ,stockUnits: "Units in stock"
            ,lowStock: "Low-stock products"
            ,inventoryValue: "Inventory value, sum"
            ,quickControl: "Quick control"
            ,seeAll: "View all →"
            ,workflow: "Workflow"
            ,quickActions: "Quick actions"
            ,restock: "Restock the warehouse"
            ,startSale: "Start a sale"
            ,completeOrder: "Complete the order"
            ,checkInventory: "Check all stock"
            ,recentInventory: "Inventory"
            ,recentProducts: "Recently added products"
            ,newProduct: "+ New product"
            ,productStatus: "Status"
            ,statusAvailable: "Available"
            ,statusLow: "Low stock"
            ,units: "units"
            ,allGood: "All stock is healthy"
            ,noLowStock: "There are no low-stock products."
            ,left: "left"
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

    function getSystemLanguage() {
        var navigatorLanguage = (navigator.language || navigator.userLanguage || 'uz').toLowerCase();
        if (navigatorLanguage.indexOf('ru') === 0) return 'ru';
        if (navigatorLanguage.indexOf('en') === 0) return 'en';
        return 'uz';
    }

    document.addEventListener('DOMContentLoaded', function () {
        var savedLanguage = localStorage.getItem('pharmacy-language') || getSystemLanguage();
        applyLanguage(savedLanguage);

        var languageSelect = document.getElementById('languageSelect');
        if (languageSelect) {
            languageSelect.addEventListener('change', function () {
                applyLanguage(languageSelect.value);
            });
        }

        var themeToggle = document.getElementById('themeToggle');
        var deviceTheme = window.matchMedia('(prefers-color-scheme: dark)');
        var savedTheme = localStorage.getItem('pharmacy-theme-mode') || 'device';

        function setTheme(isDark) {
            document.body.classList.toggle('dark-theme', isDark);
            if (themeToggle) {
                themeToggle.textContent = isDark ? '☀' : '☾';
                themeToggle.title = isDark ? 'Light mode ga o\'tish' : 'Dark mode ga o\'tish';
            }
        }

        function syncThemeFromPreference() {
            var shouldUseDark = savedTheme === 'dark' || (savedTheme === 'device' && deviceTheme.matches);
            setTheme(shouldUseDark);
        }

        function updateThemePreference(mode) {
            savedTheme = mode;
            localStorage.setItem('pharmacy-theme-mode', mode);
            syncThemeFromPreference();
        }

        syncThemeFromPreference();
        if (deviceTheme.addEventListener) {
            deviceTheme.addEventListener('change', function () {
                if (savedTheme === 'device') {
                    syncThemeFromPreference();
                }
            });
        } else if (deviceTheme.addListener) {
            deviceTheme.addListener(function () {
                if (savedTheme === 'device') {
                    syncThemeFromPreference();
                }
            });
        }
        if (themeToggle) {
            themeToggle.addEventListener('click', function () {
                if (savedTheme === 'device') {
                    updateThemePreference(document.body.classList.contains('dark-theme') ? 'light' : 'dark');
                    return;
                }
                if (savedTheme === 'dark') {
                    updateThemePreference('light');
                    return;
                }
                updateThemePreference('device');
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
