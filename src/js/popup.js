import "../scss/components/_popup.scss";

class MainPopup {
  constructor(popup) {
    this.popup = popup;
    this.main = this.popup.querySelector("[data-popup-main]");
    this.togglerOpenSelectors = this.popup.dataset.popupTriggerSelector;
    this.togglersOpen = this.togglerOpenSelectors && this.isValidSelector(this.togglerOpenSelectors) ? document.querySelectorAll(this.togglerOpenSelectors) : [];
    this.togglersClose = this.popup.querySelectorAll("[data-popup-toggler-close]");
    this.focusableElements = this.getFocusableElements();
    this.firstFocusableElement = this.focusableElements[0];
    this.lastFocusableElement = this.focusableElements[this.focusableElements.length - 1];
    this.activeClass = "active";
    this.popupOpenedBy = undefined;

    const windowLocationHash = window.location.hash;
    if (windowLocationHash) {
      this.togglersOpen.forEach((toggler) => {
        const togglerHash = toggler.hash;
        if (togglerHash && togglerHash === windowLocationHash) {
          this.popupShow();
        }
      });
    }

    if (this.togglersOpen.length) {
      this.togglersOpen.forEach((togglerOpen) => {
        togglerOpen.addEventListener("click", (e) => {
          e.preventDefault();
          this.popupShow();
          this.popupOpenedBy = togglerOpen;
        });
      });
    }

    if (this.togglersOpen.length) {
      this.togglersClose.forEach((togglerClose) => {
        togglerClose.addEventListener("click", (e) => {
          e.preventDefault();
          this.popupClose();
        });
      });
    }

    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape") {
        this.popupClose();
      }
    });

    this.popup.addEventListener("click", () => {
      this.popupClose();
    });

    this.main.addEventListener("click", (e) => {
      e.stopPropagation();
    });
  }

  isValidSelector(selector) {
    try {
      document.querySelectorAll(selector);
    } catch (e) {
      if (e instanceof DOMException) {
        return false;
      }
    }
    return true;
  }

  isActive() {
    return this.popup.classList.contains(this.activeClass) ? true : false;
  }

  focusTrap() {
    this.popup.addEventListener("keydown", (event) => {
      if (event.key === "Tab" || event.keyCode === 9) {
        if (event.shiftKey) {
          // if shift key pressed for shift + tab combination
          if (document.activeElement === this.firstFocusableElement) {
            event.preventDefault();
            this.lastFocusableElement.focus();
          }
        } else {
          // if tab key is pressed
          if (document.activeElement === this.lastFocusableElement) {
            event.preventDefault();
            this.firstFocusableElement.focus();
          }
        }
      }
    });
  }

  getFocusableElements() {
    return Array.from(this.popup.querySelectorAll('a[href], button, input, textarea, select, details, [tabindex]:not([tabindex="-1"])')).filter(
      (el) => !el.hasAttribute("disabled") && !el.getAttribute("aria-hidden") && el.type !== "hidden"
    );
  }

  popupShow() {
    if (!this.isActive()) {
      this.popup.classList.add(this.activeClass);
      this.popup.scrollTo(0, 0);
      this.popup.addEventListener("transitionend", (event) => {
        if (event.target === this.popup && this.isActive()) {
          this.firstFocusableElement.focus();
        }
      });
      this.focusTrap();
    }
  }

  popupClose() {
    if (this.isActive()) {
      this.popup.classList.remove(this.activeClass);
      this.popupOpenedBy?.focus({
        preventScroll: true,
      });
    }
  }
}

const popups = document.querySelectorAll("[data-popup]");

popups.forEach((popup) => {
  new MainPopup(popup);
});
