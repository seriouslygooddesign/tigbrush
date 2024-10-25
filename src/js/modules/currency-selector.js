export function currencySelector() {
	const label = document.querySelector("[data-currency-label]");
	const buttons = document.querySelectorAll("[data-currency-button]");
	const priceItems = document.querySelectorAll(".currency-list__item");

	const COOKIE_NAME = "selectedCurrency";
	const COOKIE_EXPIRY_DAYS = 7;

	const setCookie = (name, value, days) => {
		const date = new Date(Date.now() + days * 864e5);
		document.cookie = `${name}=${value};expires=${date.toUTCString()};path=/`;
	};

	const getCookie = (name) => {
		return (
			document.cookie
				.split("; ")
				.find((row) => row.startsWith(`${name}=`))
				?.split("=")[1] || null
		);
	};

	const updateCurrency = (currency) => {
		if (!label) return;
		label.textContent = currency.toUpperCase();

		buttons.forEach((button) => {
			button.classList.toggle("active", button.dataset.currencyButton.toLowerCase() === currency);
		});

		priceItems.forEach((item) => {
			item.classList.toggle("active", item.dataset.price === currency);
		});
	};

	if (buttons.length > 0) {
		const savedCurrency = getCookie(COOKIE_NAME) || buttons[0]?.dataset.currencyButton?.toLowerCase();

		if (savedCurrency) {
			updateCurrency(savedCurrency);
		}

		buttons.forEach((button) => {
			button.addEventListener("click", () => {
				const selectedCurrency = button.dataset.currencyButton.toLowerCase();
				setCookie(COOKIE_NAME, selectedCurrency, COOKIE_EXPIRY_DAYS);
				updateCurrency(selectedCurrency);
			});
		});
	}
}
