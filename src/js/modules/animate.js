export function animate() {
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
