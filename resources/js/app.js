import './bootstrap';
import collapse from '@alpinejs/collapse';
import intersect from '@alpinejs/intersect';
import * as htmlToImage from 'html-to-image';
import { toPng, toJpeg, toBlob, toPixelData, toSvg } from 'html-to-image';

Alpine.plugin(collapse);
Alpine.plugin(intersect);

window.htmlToImage = htmlToImage;

