import "./bootstrap";
import "flowbite";
import Alpine from "alpinejs";
import Swal from "sweetalert2";
import jQuery from "jquery";

window.Alpine = Alpine;
window.Swal = swal;
window.$ = jQuery;

Alpine.start();
Swal.start();
