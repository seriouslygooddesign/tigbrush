/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/scss/style.scss":
/*!*****************************!*\
  !*** ./src/scss/style.scss ***!
  \*****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/js/modules/accordion.js":
/*!*************************************!*\
  !*** ./src/js/modules/accordion.js ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   accordion: () => (/* binding */ accordion)
/* harmony export */ });
/* harmony import */ var _helpers__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./helpers */ "./src/js/modules/helpers.js");


function accordion() {
	const accordionHandler = (accordion) => {
		const accordionAriaControls = accordion.getAttribute("aria-controls");
		const accordionItem = accordion.closest("[data-accordion-item]");
		(0,_helpers__WEBPACK_IMPORTED_MODULE_0__.toggleVisibility)(document.getElementById(accordionAriaControls));
		accordionItem.classList.toggle(_helpers__WEBPACK_IMPORTED_MODULE_0__.activeClass);

		accordion.setAttribute("aria-expanded", accordion.getAttribute("aria-expanded") === "false" ? "true" : "false");
	};

	const accordionTogglers = document.querySelectorAll("[data-accordion-toggler]");
	accordionTogglers.forEach((accordionToggler) => {
		accordionToggler.addEventListener("click", () => {
			accordionHandler(accordionToggler);
		});
	});
}


/***/ }),

/***/ "./src/js/modules/animate.js":
/*!***********************************!*\
  !*** ./src/js/modules/animate.js ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   animate: () => (/* binding */ animate)
/* harmony export */ });
function animate() {
  const els = document.querySelectorAll("[data-animate]");
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("animate-show");
          observer.unobserve(entry.target);
        }
      });
    },
    {
      rootMargin: "-50px",
    }
  );
  els.forEach((el) => {
    observer.observe(el);
  });
}


/***/ }),

/***/ "./src/js/modules/currency-selector.js":
/*!*********************************************!*\
  !*** ./src/js/modules/currency-selector.js ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   currencySelector: () => (/* binding */ currencySelector)
/* harmony export */ });
function currencySelector() {
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


/***/ }),

/***/ "./src/js/modules/dropdown.js":
/*!************************************!*\
  !*** ./src/js/modules/dropdown.js ***!
  \************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   dropdown: () => (/* binding */ dropdown),
/* harmony export */   overlayMenuDropdownsRemoveActiveState: () => (/* binding */ overlayMenuDropdownsRemoveActiveState)
/* harmony export */ });
/* harmony import */ var _overlay_menu__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./overlay-menu */ "./src/js/modules/overlay-menu.js");
/* harmony import */ var _helpers__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./helpers */ "./src/js/modules/helpers.js");



function getActiveDropdowns() {
  return document.querySelectorAll("[data-dropdown]." + _helpers__WEBPACK_IMPORTED_MODULE_1__.activeClass);
}

function dropdownToggleActiveState(dropdown) {
  dropdown.classList.toggle(_helpers__WEBPACK_IMPORTED_MODULE_1__.activeClass);
}

function overlayMenuDropdownsRemoveActiveState() {
  getActiveDropdowns().forEach((activeDropdown) => {
    if (isOverlayMenuDropdown(activeDropdown)) {
      dropdownToggleActiveState(activeDropdown);
    }
  });
}

function isOverlayMenuDropdown(dropdown) {
  return (0,_overlay_menu__WEBPACK_IMPORTED_MODULE_0__.isOverlayMenu)() && dropdown.getAttribute("data-dropdown-location") === "overlay-menu";
}

function dropdown() {
  const dropdowns = document.querySelectorAll("[data-dropdown]");
  dropdowns.forEach((dropdown) => {
    const dropdownToggler = dropdown.querySelector("[data-dropdown-toggler]");
    const dropdownTogglerBack = dropdown.querySelector("[data-dropdown-toggler-back]");
    const dropdownTogglers = [dropdownToggler, dropdownTogglerBack];
    dropdownTogglers.forEach((dropdownToggler) => {
      dropdownToggler?.addEventListener("click", (e) => {
        if ((0,_helpers__WEBPACK_IMPORTED_MODULE_1__.isTouchDevice)() || isOverlayMenuDropdown(dropdown)) {
          e.preventDefault();
          dropdownToggleActiveState(dropdown);
        }
      });
    });
  });

  //Document Click
  document.addEventListener("click", (e) => {
    getActiveDropdowns().forEach((activeDropdown) => {
      if (!isOverlayMenuDropdown(activeDropdown) && !activeDropdown.contains(e.target)) {
        dropdownToggleActiveState(activeDropdown);
      }
    });
  });

  //Escape Click
  document.addEventListener("keydown", (e) => {
    if (e.key == "Escape") {
      getActiveDropdowns().forEach((activeDropdown) => {
        dropdownToggleActiveState(activeDropdown);
      });
    }
  });
}


/***/ }),

/***/ "./src/js/modules/helpers.js":
/*!***********************************!*\
  !*** ./src/js/modules/helpers.js ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   activeClass: () => (/* binding */ activeClass),
/* harmony export */   isOverlayMenu: () => (/* binding */ isOverlayMenu),
/* harmony export */   isTouchDevice: () => (/* binding */ isTouchDevice),
/* harmony export */   toggleVisibility: () => (/* binding */ toggleVisibility),
/* harmony export */   visibleClass: () => (/* binding */ visibleClass)
/* harmony export */ });
function isTouchDevice() {
  return window.matchMedia("(pointer: coarse)").matches;
}

function isOverlayMenu() {
  const overlayMenuBreakpoint = parseInt(window.getComputedStyle(document.documentElement).getPropertyValue("--overlay-menu-breakpoint")) || false;
  return typeof overlayMenuBreakpoint === "number" ? window.innerWidth < overlayMenuBreakpoint : true;
}

const activeClass = "active";

const visibleClass = "element-visible";

function toggleVisibility(element) {
  element.classList.toggle(visibleClass);
}


/***/ }),

/***/ "./src/js/modules/overlay-menu.js":
/*!****************************************!*\
  !*** ./src/js/modules/overlay-menu.js ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   isOverlayMenu: () => (/* binding */ isOverlayMenu),
/* harmony export */   overlayMenu: () => (/* binding */ overlayMenu)
/* harmony export */ });
/* harmony import */ var _dropdown__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./dropdown */ "./src/js/modules/dropdown.js");
/* harmony import */ var _helpers__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./helpers */ "./src/js/modules/helpers.js");


function isOverlayMenu() {
	const overlayMenuBreakpoint =
		parseInt(window.getComputedStyle(document.documentElement).getPropertyValue("--overlay-menu-breakpoint")) ||
		false;
	return typeof overlayMenuBreakpoint === "number" ? window.innerWidth < overlayMenuBreakpoint : true;
}

function overlayMenu() {
	const overlayMenu = document.querySelector("[data-overlay-menu]");
	if (!overlayMenu) return;
	const overlayMenuBody = document.querySelector("[data-overlay-menu-body]");
	const overlayMenuTogglers = document.querySelectorAll("[data-overlay-menu-toggler]");
	const overlayMenuCustomLinks = overlayMenu.querySelectorAll(".menu-item-type-custom:not(.main-menu__dropdown) > a");

	const changingClass = "changing";

	const isOverlayMenuActive = () => {
		return isOverlayMenu() && overlayMenu.classList.contains(_helpers__WEBPACK_IMPORTED_MODULE_1__.activeClass);
	};

	const overlayMenuToggleActiveState = () => {
		overlayMenu.classList.toggle(_helpers__WEBPACK_IMPORTED_MODULE_1__.activeClass);
		overlayMenu.classList.add(changingClass);
		overlayMenu.addEventListener("transitionend", () => {
			overlayMenu.classList.remove(changingClass);
		});
		if (!isOverlayMenuActive()) {
			(0,_dropdown__WEBPACK_IMPORTED_MODULE_0__.overlayMenuDropdownsRemoveActiveState)();
		}
	};

	// Force scroll up when vertical scrollbar exists in overlay menu
	const mainMenus = document.querySelectorAll("[data-main-menu]");
	mainMenus.forEach((mainMenu) => {
		const dropdownTogglers = mainMenu?.querySelectorAll("[data-dropdown-toggler]");
		dropdownTogglers.forEach((dropdownToggler) => {
			dropdownToggler.addEventListener("click", () => {
				if (isOverlayMenu()) {
					const currentDropdownMenu = dropdownToggler.closest("[data-dropdown-menu]");
					const childDropdownMenu = dropdownToggler
						.closest("[data-dropdown]")
						.querySelector("[data-dropdown-menu]");
					const scrollTopElements = [overlayMenuBody, childDropdownMenu, currentDropdownMenu];
					scrollTopElements.forEach((scrollTopElement) => {
						scrollTopElement?.scrollTo(0, 0);
					});
				}
			});
		});
	});

	//Toggler Click
	overlayMenuTogglers.forEach((toggler) => {
		toggler.addEventListener("click", (e) => {
			overlayMenuToggleActiveState();
		});
	});

	//Custom Link Click
	overlayMenuCustomLinks.forEach((link) =>
		link.addEventListener("click", (e) => {
			const target = document.getElementById(e.target.hash?.substring(1));
			if (isOverlayMenuActive() && target) overlayMenuToggleActiveState();
		})
	);

	//Escape Click
	document.addEventListener("keydown", (e) => {
		if (e.key == "Escape" && isOverlayMenuActive()) {
			overlayMenuToggleActiveState();
		}
	});
}


/***/ }),

/***/ "./src/js/modules/pdf-links.js":
/*!*************************************!*\
  !*** ./src/js/modules/pdf-links.js ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   pdfLinks: () => (/* binding */ pdfLinks)
/* harmony export */ });
function pdfLinks() {
  const pdfLinks = document.querySelectorAll('a[href$=".pdf"]');
  if (pdfLinks.length) {
    pdfLinks.forEach((link) => {
      link.setAttribute("target", "_blank");
      link.setAttribute("rel", "noopener noreferrer");
    });
  }
}


/***/ }),

/***/ "./src/js/modules/preload.js":
/*!***********************************!*\
  !*** ./src/js/modules/preload.js ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   preload: () => (/* binding */ preload)
/* harmony export */ });
function preload() {
  if (document.readyState === "interactive") {
    document.body.classList.remove("preload");
  }
}


/***/ }),

/***/ "./src/js/modules/tabs.js":
/*!********************************!*\
  !*** ./src/js/modules/tabs.js ***!
  \********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   tabs: () => (/* binding */ tabs)
/* harmony export */ });
/* harmony import */ var _helpers__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./helpers */ "./src/js/modules/helpers.js");


function tabs() {
  function tabHandler(tab) {
    // Do nothing if the current tab has the .active class
    if (tab.classList.contains(_helpers__WEBPACK_IMPORTED_MODULE_0__.activeClass)) {
      return;
    }

    const tabsParent = tab.closest("[data-tabs]");

    // Remove active item
    const activeTab = tabsParent.querySelector("[data-tab]." + _helpers__WEBPACK_IMPORTED_MODULE_0__.activeClass);
    activeTab.classList.remove(_helpers__WEBPACK_IMPORTED_MODULE_0__.activeClass);
    activeTab.setAttribute("aria-selected", "false");

    // Add active item
    tab.classList.add(_helpers__WEBPACK_IMPORTED_MODULE_0__.activeClass);
    tab.setAttribute("aria-selected", "true");

    // Toggle tab panels visibility
    const visibleTabPanel = tabsParent.querySelector(`.${_helpers__WEBPACK_IMPORTED_MODULE_0__.visibleClass}`);
    (0,_helpers__WEBPACK_IMPORTED_MODULE_0__.toggleVisibility)(visibleTabPanel);
    const targetTabPanel = document.getElementById(tab.getAttribute("aria-controls"));
    (0,_helpers__WEBPACK_IMPORTED_MODULE_0__.toggleVisibility)(targetTabPanel);

    // Scroll to tab on mobile within the scrollbar
    const tabList = tabsParent.querySelector("[data-tablist]");
    const tabListStyles = window.getComputedStyle(tabList);
    const tabListStylesLeftOffset = parseInt(tabListStyles.paddingLeft);
    const scrollLeft = tab.getBoundingClientRect().left - tabListStylesLeftOffset;
    tabList.scrollLeft += scrollLeft;
  }

  const tabs = document.querySelectorAll("[data-tab]");
  tabs.forEach((tab) => {
    tab.addEventListener("click", function () {
      tabHandler(tab);
    });
  });
}


/***/ }),

/***/ "./src/js/modules/video-autoplay.js":
/*!******************************************!*\
  !*** ./src/js/modules/video-autoplay.js ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   videoAutoplay: () => (/* binding */ videoAutoplay)
/* harmony export */ });
//Play background video on client side
function videoAutoplay() {
  const videoSources = document.querySelectorAll("source");
  if (videoSources.length) {
    videoSources.forEach((source) => {
      const dataSrc = source.dataset.src;
      if (dataSrc) {
        source.src = source.dataset.src;
        source.parentElement.load();
      }
    });
  }
}


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!************************!*\
  !*** ./src/js/main.js ***!
  \************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _scss_style_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../scss/style.scss */ "./src/scss/style.scss");
/* harmony import */ var _modules_accordion__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./modules/accordion */ "./src/js/modules/accordion.js");
/* harmony import */ var _modules_tabs__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./modules/tabs */ "./src/js/modules/tabs.js");
/* harmony import */ var _modules_overlay_menu__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./modules/overlay-menu */ "./src/js/modules/overlay-menu.js");
/* harmony import */ var _modules_animate__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./modules/animate */ "./src/js/modules/animate.js");
/* harmony import */ var _modules_video_autoplay__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./modules/video-autoplay */ "./src/js/modules/video-autoplay.js");
/* harmony import */ var _modules_preload__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./modules/preload */ "./src/js/modules/preload.js");
/* harmony import */ var _modules_pdf_links__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./modules/pdf-links */ "./src/js/modules/pdf-links.js");
/* harmony import */ var _modules_dropdown__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./modules/dropdown */ "./src/js/modules/dropdown.js");
/* harmony import */ var _modules_currency_selector__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./modules/currency-selector */ "./src/js/modules/currency-selector.js");












(0,_modules_overlay_menu__WEBPACK_IMPORTED_MODULE_3__.overlayMenu)();

(0,_modules_dropdown__WEBPACK_IMPORTED_MODULE_8__.dropdown)();

(0,_modules_pdf_links__WEBPACK_IMPORTED_MODULE_7__.pdfLinks)();

(0,_modules_preload__WEBPACK_IMPORTED_MODULE_6__.preload)();

(0,_modules_animate__WEBPACK_IMPORTED_MODULE_4__.animate)();

(0,_modules_video_autoplay__WEBPACK_IMPORTED_MODULE_5__.videoAutoplay)();

(0,_modules_accordion__WEBPACK_IMPORTED_MODULE_1__.accordion)();

(0,_modules_tabs__WEBPACK_IMPORTED_MODULE_2__.tabs)();

(0,_modules_currency_selector__WEBPACK_IMPORTED_MODULE_9__.currencySelector)();

})();

/******/ })()
;
//# sourceMappingURL=main.js.map