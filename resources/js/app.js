import './bootstrap';
import collapse from '@alpinejs/collapse';
import intersect from '@alpinejs/intersect';
import * as htmlToImage from 'html-to-image';
import { toPng, toJpeg, toBlob, toPixelData, toSvg } from 'html-to-image';
import html2canvas from 'html2canvas';

Alpine.plugin(collapse);
Alpine.plugin(intersect);

window.htmlToImage = htmlToImage;
window.html2canvas = html2canvas;

