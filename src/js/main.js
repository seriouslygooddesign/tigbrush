import "../scss/style.scss";

import { accordion } from "./modules/accordion";
import { tabs } from "./modules/tabs";
import { overlayMenu } from "./modules/overlay-menu";
import { animate } from "./modules/animate";
import { videoAutoplay } from "./modules/video-autoplay";
import { preload } from "./modules/preload";
import { pdfLinks } from "./modules/pdf-links";
import { dropdown } from "./modules/dropdown";
import { sectionScroll } from "./modules/scroll-section";

overlayMenu();

dropdown();

pdfLinks();

preload();

animate();

videoAutoplay();

accordion();

tabs();

sectionScroll();
