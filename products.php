<?php
$page_title = 'Products | Cariox';
$page_desc = 'Explore industrial coding, inspection, and packaging systems from Cariox Technologies.';
include __DIR__ . '/includes/header.php';
?>
<div class="inner-vector">
    <picture><img src="public/images/inner/inner-vector.png" alt="About Us"></picture>
</div>
<section class="inner-banner products-banner">
    <div class="container-ctn w-100">
        <div class="content">
            <h1 class="title">Products</h1>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="index.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path
                            d="M12 12.75H6M2.25 8.9925V10.875C2.25 13.35 2.25 14.5875 3.01875 15.3563C3.7875 16.125 5.025 16.125 7.5 16.125H10.5C12.975 16.125 14.2125 16.125 14.9813 15.3563C15.75 14.5875 15.75 13.35 15.75 10.875V8.9925C15.75 7.731 15.75 7.101 15.483 6.555C15.216 6.009 14.718 5.622 13.7235 4.848L12.2235 3.68175C10.6748 2.47725 9.9 1.875 9 1.875C8.1 1.875 7.32525 2.47725 5.7765 3.68175L4.2765 4.848C3.28125 5.622 2.784 6.009 2.517 6.555C2.25 7.101 2.25 7.731 2.25 8.9925Z"
                            stroke="black" stroke-width="1.125" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Home
                </a>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path d="M4.5 10.125H7.875V11.25H4.5V10.125ZM4.5 12.375H10.125V13.5H4.5V12.375Z"
                            fill="#F04149" />
                        <path
                            d="M14.625 2.25H3.375C3.07677 2.25045 2.79088 2.36912 2.58 2.58C2.36912 2.79088 2.25045 3.07677 2.25 3.375V14.625C2.25045 14.9232 2.36912 15.2091 2.58 15.42C2.79088 15.6309 3.07677 15.7496 3.375 15.75H14.625C14.9232 15.7496 15.2091 15.6309 15.42 15.42C15.6309 15.2091 15.7496 14.9232 15.75 14.625V3.375C15.7496 3.07677 15.6309 2.79088 15.42 2.58C15.2091 2.36912 14.9232 2.25045 14.625 2.25ZM10.125 3.375V5.625H7.875V3.375H10.125ZM3.375 14.625V3.375H6.75V6.75H11.25V3.375H14.625L14.6256 14.625H3.375Z"
                            fill="#F04149" />
                    </svg>
                    Products
                </span>
            </nav>
        </div>
    </div>
</section>

<!-- Mobile sticky actions -->
<div class="product-mobile-actions">
    <button type="button" class="product-mobile-btn product-mobile-btn--sort" id="productSortToggle"
        aria-label="Open sorting options" aria-expanded="false" aria-controls="productSortDrawer">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none">
            <path d="M3 6H21M6 12H18M10 18H14" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
        Sort
    </button>
    <button type="button" class="product-mobile-btn product-mobile-btn--filter" id="productFilterToggle"
        aria-label="Open product filters" aria-expanded="false" aria-controls="productSidebarDrawer">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none">
            <path d="M3 6H21M8 12H16M11 18H13" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
        Filter
    </button>
</div>

<!-- Sort Drawer -->
<div class="product-sort-drawer" id="productSortDrawer" aria-label="Sort options">
    <div class="product-sort-drawer__header">
        <h4>Sort By</h4>
        <button class="product-sort-drawer__close" id="productSortClose" aria-label="Close sort options">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </button>
    </div>
    <div class="product-sort-drawer__body">
        <div class="product-sidebar__sort">
            <label class="product-sidebar__option">
                <input type="radio" name="product-sort" value="newest" checked>
                <span class="product-sidebar__radio"></span>
                <span class="product-sidebar__label">Newest Arrivals</span>
            </label>
            <label class="product-sidebar__option">
                <input type="radio" name="product-sort" value="popularity">
                <span class="product-sidebar__radio"></span>
                <span class="product-sidebar__label">Most Popular</span>
            </label>
            <label class="product-sidebar__option">
                <input type="radio" name="product-sort" value="az">
                <span class="product-sidebar__radio"></span>
                <span class="product-sidebar__label">Name: A to Z</span>
            </label>
            <label class="product-sidebar__option">
                <input type="radio" name="product-sort" value="za">
                <span class="product-sidebar__radio"></span>
                <span class="product-sidebar__label">Name: Z to A</span>
            </label>
        </div>
    </div>
</div>

<!-- Sidebar overlay backdrop -->
<!-- Sidebar overlay backdrop -->
<div class="product-sidebar-overlay" id="productSidebarOverlay" aria-hidden="true"></div>

<section class="product-listing commonPadding-120">
    <div class="container-ctn">
        <div class="product-listing__layout justify-content-between">
            <aside class="product-sidebar" id="productSidebarDrawer" aria-label="Product filters">
                <button class="product-sidebar__close" id="productSidebarClose" aria-label="Close filters">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </button>
                <div class="product-sidebar__panel">
                    <h3>Categories</h3>
                    <div class="product-sidebar__panel-body">
                        <div class="product-sidebar__group">
                            <div class="accordion product-sidebar__main-accordion" id="productSidebarMainAccordion">
                                <div class="accordion-item product-sidebar__main-item">
                                    <h4 class="accordion-header" id="productSidebarHeadingInkJet">
                                        <button class="accordion-button product-sidebar__main-link active" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#productSidebarInkJet"
                                            aria-expanded="true" aria-controls="productSidebarInkJet">
                                            <span>Ink-Jet Printers</span>
                                            <span aria-hidden="true" class="product-sidebar__main-icon"></span>
                                        </button>
                                    </h4>
                                    <div id="productSidebarInkJet" class="accordion-collapse collapse show"
                                        aria-labelledby="productSidebarHeadingInkJet"
                                        data-bs-parent="#productSidebarMainAccordion">
                                        <div class="accordion-body product-sidebar__main-body">
                                            <div class="accordion product-sidebar__sub-accordion"
                                                id="productSidebarSubAccordion">
                                                <div class="accordion-item product-sidebar__sub-item">
                                                    <h4 class="accordion-header"
                                                        id="productSidebarHeadingSmallCharacter">
                                                        <button
                                                            class="accordion-button product-sidebar__sub-link active"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#productSidebarSmallCharacter"
                                                            aria-expanded="true"
                                                            aria-controls="productSidebarSmallCharacter">
                                                            <span>Small Character Printers</span>
                                                            <span aria-hidden="true"
                                                                class="product-sidebar__sub-icon"></span>
                                                        </button>
                                                    </h4>
                                                    <div id="productSidebarSmallCharacter"
                                                        class="accordion-collapse collapse show"
                                                        aria-labelledby="productSidebarHeadingSmallCharacter"
                                                        data-bs-parent="#productSidebarSubAccordion">
                                                        <div class="accordion-body product-sidebar__nested">
                                                            <label class="product-sidebar__option  ">
                                                                <input type="checkbox" name="product-filter[]"
                                                                    value="ebs-6500" checked>
                                                                <span class="product-sidebar__check"></span>
                                                                <span class="product-sidebar__label">EBS 6500</span>
                                                            </label>
                                                            <label class="product-sidebar__option">
                                                                <input type="checkbox" name="product-filter[]"
                                                                    value="ebs-6800p">
                                                                <span class="product-sidebar__check"></span>
                                                                <span class="product-sidebar__label">EBS 6800P</span>
                                                            </label>
                                                            <label class="product-sidebar__option">
                                                                <input type="checkbox" name="product-filter[]"
                                                                    value="ebs-6600">
                                                                <span class="product-sidebar__check"></span>
                                                                <span class="product-sidebar__label">EBS 6600</span>
                                                            </label>
                                                            <label class="product-sidebar__option">
                                                                <input type="checkbox" name="product-filter[]"
                                                                    value="ebs-6900">
                                                                <span class="product-sidebar__check"></span>
                                                                <span class="product-sidebar__label">EBS 6900</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item product-sidebar__sub-item">
                                                    <h4 class="accordion-header"
                                                        id="productSidebarHeadingLargeCharacter">
                                                        <button
                                                            class="accordion-button product-sidebar__sub-link collapsed"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#productSidebarLargeCharacter"
                                                            aria-expanded="false"
                                                            aria-controls="productSidebarLargeCharacter">
                                                            <span>Large Character Printers</span>
                                                            <span aria-hidden="true"
                                                                class="product-sidebar__sub-icon"></span>
                                                        </button>
                                                    </h4>
                                                    <div id="productSidebarLargeCharacter"
                                                        class="accordion-collapse collapse"
                                                        aria-labelledby="productSidebarHeadingLargeCharacter"
                                                        data-bs-parent="#productSidebarSubAccordion">
                                                        <div class="accordion-body product-sidebar__nested">
                                                            <label class="product-sidebar__option">
                                                                <input type="checkbox" name="product-filter[]"
                                                                    value="ebs-1500">
                                                                <span class="product-sidebar__check"></span>
                                                                <span class="product-sidebar__label">EBS 1500</span>
                                                            </label>
                                                            <label class="product-sidebar__option">
                                                                <input type="checkbox" name="product-filter[]"
                                                                    value="ebs-2600">
                                                                <span class="product-sidebar__check"></span>
                                                                <span class="product-sidebar__label">EBS 2600</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item product-sidebar__sub-item">
                                                    <h4 class="accordion-header" id="productSidebarHeadingHandjet">
                                                        <button
                                                            class="accordion-button product-sidebar__sub-link collapsed"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#productSidebarHandjet"
                                                            aria-expanded="false" aria-controls="productSidebarHandjet">
                                                            <span>Handjet Printers</span>
                                                            <span aria-hidden="true"
                                                                class="product-sidebar__sub-icon"></span>
                                                        </button>
                                                    </h4>
                                                    <div id="productSidebarHandjet" class="accordion-collapse collapse"
                                                        aria-labelledby="productSidebarHeadingHandjet"
                                                        data-bs-parent="#productSidebarSubAccordion">
                                                        <div class="accordion-body product-sidebar__nested">
                                                            <label class="product-sidebar__option">
                                                                <input type="checkbox" name="product-filter[]"
                                                                    value="ebs-250">
                                                                <span class="product-sidebar__check"></span>
                                                                <span class="product-sidebar__label">EBS 250</span>
                                                            </label>
                                                            <label class="product-sidebar__option">
                                                                <input type="checkbox" name="product-filter[]"
                                                                    value="ebs-260">
                                                                <span class="product-sidebar__check"></span>
                                                                <span class="product-sidebar__label">EBS 260</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item product-sidebar__main-item">
                                    <h4 class="accordion-header" id="productSidebarHeadingThermalTransfer">
                                        <button class="accordion-button product-sidebar__main-link collapsed"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#productSidebarThermalTransfer" aria-expanded="false"
                                            aria-controls="productSidebarThermalTransfer">
                                            <span>Thermal Transfer Printers</span>
                                            <span aria-hidden="true" class="product-sidebar__main-icon"></span>
                                        </button>
                                    </h4>
                                    <div id="productSidebarThermalTransfer" class="accordion-collapse collapse"
                                        aria-labelledby="productSidebarHeadingThermalTransfer"
                                        data-bs-parent="#productSidebarMainAccordion">
                                        <div class="accordion-body product-sidebar__main-body">
                                            <div class="accordion product-sidebar__sub-accordion"
                                                id="productSidebarThermalTransferSubAccordion">
                                                <div class="accordion-item product-sidebar__sub-item">
                                                    <h4 class="accordion-header" id="productSidebarHeadingTtoPrinters">
                                                        <button
                                                            class="accordion-button product-sidebar__sub-link collapsed"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#productSidebarTtoPrinters"
                                                            aria-expanded="false"
                                                            aria-controls="productSidebarTtoPrinters">
                                                            <span>TTO Printers</span>
                                                            <span aria-hidden="true"
                                                                class="product-sidebar__sub-icon"></span>
                                                        </button>
                                                    </h4>
                                                    <div id="productSidebarTtoPrinters"
                                                        class="accordion-collapse collapse"
                                                        aria-labelledby="productSidebarHeadingTtoPrinters"
                                                        data-bs-parent="#productSidebarThermalTransferSubAccordion">
                                                        <div class="accordion-body product-sidebar__nested">
                                                            <label class="product-sidebar__option">
                                                                <input type="checkbox" name="product-filter[]"
                                                                    value="svm-107x70i">
                                                                <span class="product-sidebar__check"></span>
                                                                <span class="product-sidebar__label">SVM 107x70i</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item product-sidebar__sub-item">
                                                    <h4 class="accordion-header" id="productSidebarHeadingCodingUnits">
                                                        <button
                                                            class="accordion-button product-sidebar__sub-link collapsed"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#productSidebarCodingUnits"
                                                            aria-expanded="false"
                                                            aria-controls="productSidebarCodingUnits">
                                                            <span>Coding Units</span>
                                                            <span aria-hidden="true"
                                                                class="product-sidebar__sub-icon"></span>
                                                        </button>
                                                    </h4>
                                                    <div id="productSidebarCodingUnits"
                                                        class="accordion-collapse collapse"
                                                        aria-labelledby="productSidebarHeadingCodingUnits"
                                                        data-bs-parent="#productSidebarThermalTransferSubAccordion">
                                                        <div class="accordion-body product-sidebar__nested">
                                                            <label class="product-sidebar__option">
                                                                <input type="checkbox" name="product-filter[]"
                                                                    value="svm-32c">
                                                                <span class="product-sidebar__check"></span>
                                                                <span class="product-sidebar__label">SVM 32C</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item product-sidebar__main-item">
                                    <h4 class="accordion-header" id="productSidebarHeadingInspection">
                                        <button class="accordion-button product-sidebar__main-link collapsed"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#productSidebarInspection" aria-expanded="false"
                                            aria-controls="productSidebarInspection">
                                            <span>Food Inspection Systems</span>
                                            <span aria-hidden="true" class="product-sidebar__main-icon"></span>
                                        </button>
                                    </h4>
                                    <div id="productSidebarInspection" class="accordion-collapse collapse"
                                        aria-labelledby="productSidebarHeadingInspection"
                                        data-bs-parent="#productSidebarMainAccordion">
                                        <div class="accordion-body product-sidebar__main-body">
                                            <div class="accordion product-sidebar__sub-accordion"
                                                id="productSidebarInspectionSubAccordion">
                                                <div class="accordion-item product-sidebar__sub-item">
                                                    <h4 class="accordion-header" id="productSidebarHeadingXray">
                                                        <button
                                                            class="accordion-button product-sidebar__sub-link collapsed"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#productSidebarXray" aria-expanded="false"
                                                            aria-controls="productSidebarXray">
                                                            <span>X-Ray Inspection</span>
                                                            <span aria-hidden="true"
                                                                class="product-sidebar__sub-icon"></span>
                                                        </button>
                                                    </h4>
                                                    <div id="productSidebarXray" class="accordion-collapse collapse"
                                                        aria-labelledby="productSidebarHeadingXray"
                                                        data-bs-parent="#productSidebarInspectionSubAccordion">
                                                        <div class="accordion-body product-sidebar__nested">
                                                            <label class="product-sidebar__option">
                                                                <input type="checkbox" name="product-filter[]"
                                                                    value="x-ray-inspection-system">
                                                                <span class="product-sidebar__check"></span>
                                                                <span class="product-sidebar__label">X-Ray Inspection
                                                                    System</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item product-sidebar__main-item">
                                    <h4 class="accordion-header" id="productSidebarHeadingLaser">
                                        <button class="accordion-button product-sidebar__main-link collapsed"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#productSidebarLaser" aria-expanded="false"
                                            aria-controls="productSidebarLaser">
                                            <span>Laser Printers</span>
                                            <span aria-hidden="true" class="product-sidebar__main-icon"></span>
                                        </button>
                                    </h4>
                                    <div id="productSidebarLaser" class="accordion-collapse collapse"
                                        aria-labelledby="productSidebarHeadingLaser"
                                        data-bs-parent="#productSidebarMainAccordion">
                                        <div class="accordion-body product-sidebar__main-body">
                                            <div class="accordion product-sidebar__sub-accordion"
                                                id="productSidebarLaserSubAccordion">
                                                <div class="accordion-item product-sidebar__sub-item">
                                                    <h4 class="accordion-header" id="productSidebarHeadingCo2Laser">
                                                        <button
                                                            class="accordion-button product-sidebar__sub-link collapsed"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#productSidebarCo2Laser"
                                                            aria-expanded="false"
                                                            aria-controls="productSidebarCo2Laser">
                                                            <span>CO2 Laser Printers</span>
                                                            <span aria-hidden="true"
                                                                class="product-sidebar__sub-icon"></span>
                                                        </button>
                                                    </h4>
                                                    <div id="productSidebarCo2Laser" class="accordion-collapse collapse"
                                                        aria-labelledby="productSidebarHeadingCo2Laser"
                                                        data-bs-parent="#productSidebarLaserSubAccordion">
                                                        <div class="accordion-body product-sidebar__nested">
                                                            <label class="product-sidebar__option">
                                                                <input type="checkbox" name="product-filter[]"
                                                                    value="co2-laser">
                                                                <span class="product-sidebar__check"></span>
                                                                <span class="product-sidebar__label">CO2 Laser</span>
                                                            </label>
                                                            <label class="product-sidebar__option">
                                                                <input type="checkbox" name="product-filter[]"
                                                                    value="solaris-laser">
                                                                <span class="product-sidebar__check"></span>
                                                                <span class="product-sidebar__label">Solaris
                                                                    Laser</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item product-sidebar__main-item">
                                    <h4 class="accordion-header" id="productSidebarHeadingPacking">
                                        <button class="accordion-button product-sidebar__main-link collapsed"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#productSidebarPacking" aria-expanded="false"
                                            aria-controls="productSidebarPacking">
                                            <span>Packing Systems</span>
                                            <span aria-hidden="true" class="product-sidebar__main-icon"></span>
                                        </button>
                                    </h4>
                                    <div id="productSidebarPacking" class="accordion-collapse collapse"
                                        aria-labelledby="productSidebarHeadingPacking"
                                        data-bs-parent="#productSidebarMainAccordion">
                                        <div class="accordion-body product-sidebar__main-body">
                                            <div class="accordion product-sidebar__sub-accordion"
                                                id="productSidebarPackingSubAccordion">
                                                <div class="accordion-item product-sidebar__sub-item">
                                                    <h4 class="accordion-header"
                                                        id="productSidebarHeadingFillingMachines">
                                                        <button
                                                            class="accordion-button product-sidebar__sub-link collapsed"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#productSidebarFillingMachines"
                                                            aria-expanded="false"
                                                            aria-controls="productSidebarFillingMachines">
                                                            <span>Filling Machines</span>
                                                            <span aria-hidden="true"
                                                                class="product-sidebar__sub-icon"></span>
                                                        </button>
                                                    </h4>
                                                    <div id="productSidebarFillingMachines"
                                                        class="accordion-collapse collapse"
                                                        aria-labelledby="productSidebarHeadingFillingMachines"
                                                        data-bs-parent="#productSidebarPackingSubAccordion">
                                                        <div class="accordion-body product-sidebar__nested">
                                                            <label class="product-sidebar__option">
                                                                <input type="checkbox" name="product-filter[]"
                                                                    value="powder-packing-auger-filling-machine">
                                                                <span class="product-sidebar__check"></span>
                                                                <span class="product-sidebar__label">Powder Packing /
                                                                    Auger Filling Machinec </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item product-sidebar__sub-item">
                                                    <h4 class="accordion-header" id="productSidebarHeadingFeeders">
                                                        <button
                                                            class="accordion-button product-sidebar__sub-link collapsed"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#productSidebarFeeders"
                                                            aria-expanded="false" aria-controls="productSidebarFeeders">
                                                            <span>Feeders</span>
                                                            <span aria-hidden="true"
                                                                class="product-sidebar__sub-icon"></span>
                                                        </button>
                                                    </h4>
                                                    <div id="productSidebarFeeders" class="accordion-collapse collapse"
                                                        aria-labelledby="productSidebarHeadingFeeders"
                                                        data-bs-parent="#productSidebarPackingSubAccordion">
                                                        <div class="accordion-body product-sidebar__nested">
                                                            <label class="product-sidebar__option">
                                                                <input type="checkbox" name="product-filter[]"
                                                                    value="savema-feeders">
                                                                <span class="product-sidebar__check"></span>
                                                                <span class="product-sidebar__label">Savema
                                                                    Feeders</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item product-sidebar__sub-item">
                                                    <h4 class="accordion-header" id="productSidebarHeadingWeighers">
                                                        <button
                                                            class="accordion-button product-sidebar__sub-link collapsed"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#productSidebarWeighers"
                                                            aria-expanded="false"
                                                            aria-controls="productSidebarWeighers">
                                                            <span>Weighing Systems</span>
                                                            <span aria-hidden="true"
                                                                class="product-sidebar__sub-icon"></span>
                                                        </button>
                                                    </h4>
                                                    <div id="productSidebarWeighers" class="accordion-collapse collapse"
                                                        aria-labelledby="productSidebarHeadingWeighers"
                                                        data-bs-parent="#productSidebarPackingSubAccordion">
                                                        <div class="accordion-body product-sidebar__nested">
                                                            <label class="product-sidebar__option">
                                                                <input type="checkbox" name="product-filter[]"
                                                                    value="ipac-multihead-weigher">
                                                                <span class="product-sidebar__check"></span>
                                                                <span class="product-sidebar__label">iPac Multihead
                                                                    Weigher</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>



                <div class="product-sidebar__panel">
                    <h3>Brands</h3>
                    <div class="product-sidebar__panel-body">
                        <div class="product-sidebar__brands">
                            <label class="product-sidebar__brand">
                                <input type="checkbox" name="brand-filter[]" value="ebs">
                                <span class="product-sidebar__brand-mark" aria-hidden="true"></span>
                                <img src="public/images/products/brand/1.png" alt="EBS logo" width="86" height="36">
                            </label>
                            <label class="product-sidebar__brand">
                                <input type="checkbox" name="brand-filter[]" value="savema">
                                <span class="product-sidebar__brand-mark" aria-hidden="true"></span>
                                <img src="public/images/products/brand/2.png" alt="Savema logo" width="86" height="36">
                            </label>
                            <label class="product-sidebar__brand">
                                <input type="checkbox" name="brand-filter[]" value="thermo-scientific">
                                <span class="product-sidebar__brand-mark" aria-hidden="true"></span>
                                <img src="public/images/products/brand/3.png" alt="Thermo Scientific logo" width="86"
                                    height="36">
                            </label>
                            <label class="product-sidebar__brand">
                                <input type="checkbox" name="brand-filter[]" value="solaris-laser">
                                <span class="product-sidebar__brand-mark" aria-hidden="true"></span>
                                <span>Solaris Laser</span>
                            </label>
                            <label class="product-sidebar__brand">
                                <input type="checkbox" name="brand-filter[]" value="pwi">
                                <span class="product-sidebar__brand-mark" aria-hidden="true"></span>
                                <span>PWI</span>
                            </label>
                            <label class="product-sidebar__brand">
                                <input type="checkbox" name="brand-filter[]" value="ipac">
                                <span class="product-sidebar__brand-mark" aria-hidden="true"></span>
                                <span>iPac</span>
                            </label>
                        </div>
                    </div>
                </div>
            </aside>

            <div class="product-catalog">
                <div class="product-catalog__grid">
                    <article class="product-catalog-card">
                        <div class="product-catalog-card__image">
                            <img src="public/images/shop/1.png" width="249" height="249" alt="EBS 6500 printer">
                        </div>
                        <div class="product-catalog-card__content">
                            <h3>EBS 6500</h3>
                            <p>Single-Head INKJET Printer.</p>
                            <div class="product-catalog-card__actions">
                                <a data-bs-toggle="modal" data-bs-target="#siteEnquiryForm" role="button"
                                    aria-label="Open enquiry form"
                                    class="product-catalog-card__cta product-catalog-card__cta--primary">Enquire Now</a>
                                <a href="https://wa.me/+971545864310?text=I%20am%20interested%20in%20EBS%206500."
                                    target="_blank" rel="noopener"
                                    class="product-catalog-card__cta product-catalog-card__cta--secondary">WhatsApp
                                    Us</a>
                                <a href="product-detail.php" class="product-catalog-card__arrow"
                                    aria-label="View EBS 6500 details">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 11 11"
                                        fill="none">
                                        <path
                                            d="M0.800176 9.85096L9.85114 0.799996M9.85114 0.799996L9.85114 7.58822M9.85114 0.799996L3.06292 0.799997"
                                            stroke="black" stroke-width="1.6" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                    <article class="product-catalog-card">
                        <div class="product-catalog-card__image">
                            <img src="public/images/shop/2.png" width="249" height="249" alt="EBS 6800P printer">
                        </div>
                        <div class="product-catalog-card__content">
                            <h3>EBS 6800P</h3>
                            <p>Small Character Inkjet Printer.</p>
                            <div class="product-catalog-card__actions">
                                <a data-bs-toggle="modal" data-bs-target="#siteEnquiryForm" role="button"
                                    aria-label="Open enquiry form"
                                    class="product-catalog-card__cta product-catalog-card__cta--primary">Enquire Now</a>
                                <a href="https://wa.me/+971545864310?text=I%20am%20interested%20in%20EBS%206800P."
                                    target="_blank" rel="noopener"
                                    class="product-catalog-card__cta product-catalog-card__cta--secondary">WhatsApp
                                    Us</a>
                                <a href="product-detail.php" class="product-catalog-card__arrow"
                                    aria-label="View EBS 6800P details"> <svg xmlns="http://www.w3.org/2000/svg"
                                        width="11" height="11" viewBox="0 0 11 11" fill="none">
                                        <path
                                            d="M0.800176 9.85096L9.85114 0.799996M9.85114 0.799996L9.85114 7.58822M9.85114 0.799996L3.06292 0.799997"
                                            stroke="black" stroke-width="1.6" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg></a>
                            </div>
                        </div>
                    </article>
                    <article class="product-catalog-card">
                        <div class="product-catalog-card__image">
                            <img src="public/images/shop/3.png" width="249" height="249" alt="EBS 1500 printer">
                        </div>
                        <div class="product-catalog-card__content">
                            <h3>EBS 1500</h3>
                            <p>Large Character Inkjet Printer.</p>
                            <div class="product-catalog-card__actions">
                                <a data-bs-toggle="modal" data-bs-target="#siteEnquiryForm" role="button"
                                    aria-label="Open enquiry form"
                                    class="product-catalog-card__cta product-catalog-card__cta--primary">Enquire Now</a>
                                <a href="https://wa.me/+971545864310?text=I%20am%20interested%20in%20EBS%201500."
                                    target="_blank" rel="noopener"
                                    class="product-catalog-card__cta product-catalog-card__cta--secondary">WhatsApp
                                    Us</a>
                                <a href="product-detail.php" class="product-catalog-card__arrow"
                                    aria-label="View EBS 1500 details"> <svg xmlns="http://www.w3.org/2000/svg"
                                        width="11" height="11" viewBox="0 0 11 11" fill="none">
                                        <path
                                            d="M0.800176 9.85096L9.85114 0.799996M9.85114 0.799996L9.85114 7.58822M9.85114 0.799996L3.06292 0.799997"
                                            stroke="black" stroke-width="1.6" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg></a>
                            </div>
                        </div>
                    </article>
                    <article class="product-catalog-card">
                        <div class="product-catalog-card__image">
                            <img src="public/images/shop/4.png" width="249" height="249" alt="EBS 6600 printer">
                        </div>
                        <div class="product-catalog-card__content">
                            <h3>EBS 6600</h3>
                            <p>Continuous INK-JET Printer.</p>
                            <div class="product-catalog-card__actions">
                                <a data-bs-toggle="modal" data-bs-target="#siteEnquiryForm" role="button"
                                    aria-label="Open enquiry form"
                                    class="product-catalog-card__cta product-catalog-card__cta--primary">Enquire Now</a>
                                <a href="https://wa.me/+971545864310?text=I%20am%20interested%20in%20EBS%206600."
                                    target="_blank" rel="noopener"
                                    class="product-catalog-card__cta product-catalog-card__cta--secondary">WhatsApp
                                    Us</a>
                                <a href="product-detail.php" class="product-catalog-card__arrow"
                                    aria-label="View EBS 6600 details"> <svg xmlns="http://www.w3.org/2000/svg"
                                        width="11" height="11" viewBox="0 0 11 11" fill="none">
                                        <path
                                            d="M0.800176 9.85096L9.85114 0.799996M9.85114 0.799996L9.85114 7.58822M9.85114 0.799996L3.06292 0.799997"
                                            stroke="black" stroke-width="1.6" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg></a>
                            </div>
                        </div>
                    </article>
                    <article class="product-catalog-card">
                        <div class="product-catalog-card__image">
                            <img src="public/images/shop/5.png" width="249" height="249" alt="EBS 6900 printer">
                        </div>
                        <div class="product-catalog-card__content">
                            <h3>EBS 6900</h3>
                            <p>Continuous INK-JET Printer.</p>
                            <div class="product-catalog-card__actions">
                                <a data-bs-toggle="modal" data-bs-target="#siteEnquiryForm" role="button"
                                    aria-label="Open enquiry form"
                                    class="product-catalog-card__cta product-catalog-card__cta--primary">Enquire Now</a>
                                <a href="https://wa.me/+971545864310?text=I%20am%20interested%20in%20EBS%206900."
                                    target="_blank" rel="noopener"
                                    class="product-catalog-card__cta product-catalog-card__cta--secondary">WhatsApp
                                    Us</a>
                                <a href="product-detail.php" class="product-catalog-card__arrow"
                                    aria-label="View EBS 6900 details"> <svg xmlns="http://www.w3.org/2000/svg"
                                        width="11" height="11" viewBox="0 0 11 11" fill="none">
                                        <path
                                            d="M0.800176 9.85096L9.85114 0.799996M9.85114 0.799996L9.85114 7.58822M9.85114 0.799996L3.06292 0.799997"
                                            stroke="black" stroke-width="1.6" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg></a>
                            </div>
                        </div>
                    </article>
                    <article class="product-catalog-card">
                        <div class="product-catalog-card__image">
                            <img src="public/images/shop/6.png" width="249" height="249" alt="Handjet EBS 250 printer">
                        </div>
                        <div class="product-catalog-card__content">
                            <h3>Handjet EBS 250</h3>
                            <p>Portable Manual Handjet Printer.</p>
                            <div class="product-catalog-card__actions">
                                <a data-bs-toggle="modal" data-bs-target="#siteEnquiryForm" role="button"
                                    aria-label="Open enquiry form"
                                    class="product-catalog-card__cta product-catalog-card__cta--primary">Enquire Now</a>
                                <a href="https://wa.me/+971545864310?text=I%20am%20interested%20in%20Handjet%20EBS%20250."
                                    target="_blank" rel="noopener"
                                    class="product-catalog-card__cta product-catalog-card__cta--secondary">WhatsApp
                                    Us</a>
                                <a href="product-detail.php" class="product-catalog-card__arrow"
                                    aria-label="View Handjet EBS 250 details"> <svg xmlns="http://www.w3.org/2000/svg"
                                        width="11" height="11" viewBox="0 0 11 11" fill="none">
                                        <path
                                            d="M0.800176 9.85096L9.85114 0.799996M9.85114 0.799996L9.85114 7.58822M9.85114 0.799996L3.06292 0.799997"
                                            stroke="black" stroke-width="1.6" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg></a>
                            </div>
                        </div>
                    </article>
                    <article class="product-catalog-card">
                        <div class="product-catalog-card__image">
                            <img src="public/images/shop/7.png" width="249" height="249" alt="Handjet EBS 250 printer">
                        </div>
                        <div class="product-catalog-card__content">
                            <h3>Handjet EBS 260</h3>
                            <p>Portable Manual Handjet Printer.</p>
                            <div class="product-catalog-card__actions">
                                <a data-bs-toggle="modal" data-bs-target="#siteEnquiryForm" role="button"
                                    aria-label="Open enquiry form"
                                    class="product-catalog-card__cta product-catalog-card__cta--primary">Enquire Now</a>
                                <a href="https://wa.me/+971545864310?text=I%20am%20interested%20in%20Handjet%20EBS%20250."
                                    target="_blank" rel="noopener"
                                    class="product-catalog-card__cta product-catalog-card__cta--secondary">WhatsApp
                                    Us</a>
                                <a href="product-detail.php" class="product-catalog-card__arrow"
                                    aria-label="View Handjet EBS 250 details"> <svg xmlns="http://www.w3.org/2000/svg"
                                        width="11" height="11" viewBox="0 0 11 11" fill="none">
                                        <path
                                            d="M0.800176 9.85096L9.85114 0.799996M9.85114 0.799996L9.85114 7.58822M9.85114 0.799996L3.06292 0.799997"
                                            stroke="black" stroke-width="1.6" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg></a>
                            </div>
                        </div>
                    </article>
                    <article class="product-catalog-card">
                        <div class="product-catalog-card__image">
                            <img src="public/images/shop/8.png" width="249" height="249" alt="SVM 107x70i printer">
                        </div>
                        <div class="product-catalog-card__content">
                            <h3>SVM 107x70i</h3>
                            <p>Savema TTO Printer.</p>
                            <div class="product-catalog-card__actions">
                                <a data-bs-toggle="modal" data-bs-target="#siteEnquiryForm" role="button"
                                    aria-label="Open enquiry form"
                                    class="product-catalog-card__cta product-catalog-card__cta--primary">Enquire Now</a>
                                <a href="https://wa.me/+971545864310?text=I%20am%20interested%20in%20SVM%20107x70i."
                                    target="_blank" rel="noopener"
                                    class="product-catalog-card__cta product-catalog-card__cta--secondary">WhatsApp
                                    Us</a>
                                <a href="product-detail.php" class="product-catalog-card__arrow"
                                    aria-label="View SVM 107x70i details"> <svg xmlns="http://www.w3.org/2000/svg"
                                        width="11" height="11" viewBox="0 0 11 11" fill="none">
                                        <path
                                            d="M0.800176 9.85096L9.85114 0.799996M9.85114 0.799996L9.85114 7.58822M9.85114 0.799996L3.06292 0.799997"
                                            stroke="black" stroke-width="1.6" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg></a>
                            </div>
                        </div>
                    </article>
                    <article class="product-catalog-card">
                        <div class="product-catalog-card__image">
                            <img src="public/images/shop/9.png" width="249" height="249" alt="SVM 32C printer">
                        </div>
                        <div class="product-catalog-card__content">
                            <h3>SVM 32C</h3>
                            <p>Savema coding unit.</p>
                            <div class="product-catalog-card__actions">
                                <a data-bs-toggle="modal" data-bs-target="#siteEnquiryForm" role="button"
                                    aria-label="Open enquiry form"
                                    class="product-catalog-card__cta product-catalog-card__cta--primary">Enquire Now</a>
                                <a href="https://wa.me/+971545864310?text=I%20am%20interested%20in%20SVM%2032C."
                                    target="_blank" rel="noopener"
                                    class="product-catalog-card__cta product-catalog-card__cta--secondary">WhatsApp
                                    Us</a>
                                <a href="product-detail.php" class="product-catalog-card__arrow"
                                    aria-label="View SVM 32C details"> <svg xmlns="http://www.w3.org/2000/svg"
                                        width="11" height="11" viewBox="0 0 11 11" fill="none">
                                        <path
                                            d="M0.800176 9.85096L9.85114 0.799996M9.85114 0.799996L9.85114 7.58822M9.85114 0.799996L3.06292 0.799997"
                                            stroke="black" stroke-width="1.6" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg></a>
                            </div>
                        </div>
                    </article>
                    <article class="product-catalog-card">
                        <div class="product-catalog-card__image">
                            <img src="public/images/shop/10.png" width="249" height="249" alt="SVM 32C printer">
                        </div>
                        <div class="product-catalog-card__content">
                            <h3>SVM 53C</h3>
                            <p>SVM 53C</p>
                            <div class="product-catalog-card__actions">
                                <a data-bs-toggle="modal" data-bs-target="#siteEnquiryForm" role="button"
                                    aria-label="Open enquiry form"
                                    class="product-catalog-card__cta product-catalog-card__cta--primary">Enquire Now</a>
                                <a href="https://wa.me/+971545864310?text=I%20am%20interested%20in%20SVM%2032C."
                                    target="_blank" rel="noopener"
                                    class="product-catalog-card__cta product-catalog-card__cta--secondary">WhatsApp
                                    Us</a>
                                <a href="product-detail.php" class="product-catalog-card__arrow"
                                    aria-label="View SVM 32C details"> <svg xmlns="http://www.w3.org/2000/svg"
                                        width="11" height="11" viewBox="0 0 11 11" fill="none">
                                        <path
                                            d="M0.800176 9.85096L9.85114 0.799996M9.85114 0.799996L9.85114 7.58822M9.85114 0.799996L3.06292 0.799997"
                                            stroke="black" stroke-width="1.6" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg></a>
                            </div>
                        </div>
                    </article>
                    <article class="product-catalog-card">
                        <div class="product-catalog-card__image">
                            <img src="public/images/shop/11.png" width="249" height="249" alt="SVM 32C printer">
                        </div>
                        <div class="product-catalog-card__content">
                            <h3>SVM 107C</h3>
                            <p>SVM 107C</p>
                            <div class="product-catalog-card__actions">
                                <a data-bs-toggle="modal" data-bs-target="#siteEnquiryForm" role="button"
                                    aria-label="Open enquiry form"
                                    class="product-catalog-card__cta product-catalog-card__cta--primary">Enquire Now</a>
                                <a href="https://wa.me/+971545864310?text=I%20am%20interested%20in%20SVM%2032C."
                                    target="_blank" rel="noopener"
                                    class="product-catalog-card__cta product-catalog-card__cta--secondary">WhatsApp
                                    Us</a>
                                <a href="product-detail.php" class="product-catalog-card__arrow"
                                    aria-label="View SVM 32C details"> <svg xmlns="http://www.w3.org/2000/svg"
                                        width="11" height="11" viewBox="0 0 11 11" fill="none">
                                        <path
                                            d="M0.800176 9.85096L9.85114 0.799996M9.85114 0.799996L9.85114 7.58822M9.85114 0.799996L3.06292 0.799997"
                                            stroke="black" stroke-width="1.6" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg></a>
                            </div>
                        </div>
                    </article>
                    <article class="product-catalog-card">
                        <div class="product-catalog-card__image">
                            <img src="public/images/shop/12.png" alt="Savema Feeders">
                        </div>
                        <div class="product-catalog-card__content">
                            <h3>Savema Feeders</h3>
                            <p>Savema Feeders</p>
                            <div class="product-catalog-card__actions">
                                <a data-bs-toggle="modal" data-bs-target="#siteEnquiryForm" role="button"
                                    aria-label="Open enquiry form"
                                    class="product-catalog-card__cta product-catalog-card__cta--primary">Enquire Now</a>
                                <a href="https://wa.me/+971545864310?text=I%20am%20interested%20in%20Savema%20Feeders."
                                    target="_blank" rel="noopener"
                                    class="product-catalog-card__cta product-catalog-card__cta--secondary">WhatsApp
                                    Us</a>
                                <a href="product-detail.php" class="product-catalog-card__arrow"
                                    aria-label="View Savema Feeders details"> <svg xmlns="http://www.w3.org/2000/svg"
                                        width="11" height="11" viewBox="0 0 11 11" fill="none">
                                        <path
                                            d="M0.800176 9.85096L9.85114 0.799996M9.85114 0.799996L9.85114 7.58822M9.85114 0.799996L3.06292 0.799997"
                                            stroke="black" stroke-width="1.6" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg></a>
                            </div>
                        </div>
                    </article>
                    <article class="product-catalog-card">
                        <div class="product-catalog-card__image">
                            <img src="public/images/shop/13.png" alt="SVM 53x70i">
                        </div>
                        <div class="product-catalog-card__content">
                            <h3>SVM 53x70i</h3>
                            <p>SVM 53x70i</p>
                            <div class="product-catalog-card__actions">
                                <a data-bs-toggle="modal" data-bs-target="#siteEnquiryForm" role="button"
                                    aria-label="Open enquiry form"
                                    class="product-catalog-card__cta product-catalog-card__cta--primary">Enquire Now</a>
                                <a href="https://wa.me/+971545864310?text=I%20am%20interested%20in%20Savema%20Feeders."
                                    target="_blank" rel="noopener"
                                    class="product-catalog-card__cta product-catalog-card__cta--secondary">WhatsApp
                                    Us</a>
                                <a href="product-detail.php" class="product-catalog-card__arrow"
                                    aria-label="View Savema Feeders details"> <svg xmlns="http://www.w3.org/2000/svg"
                                        width="11" height="11" viewBox="0 0 11 11" fill="none">
                                        <path
                                            d="M0.800176 9.85096L9.85114 0.799996M9.85114 0.799996L9.85114 7.58822M9.85114 0.799996L3.06292 0.799997"
                                            stroke="black" stroke-width="1.6" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg></a>
                            </div>
                        </div>
                    </article>
                    <article class="product-catalog-card">
                        <div class="product-catalog-card__image">
                            <img src="public/images/shop/14.png" alt="SVM 53x70i">
                        </div>
                        <div class="product-catalog-card__content">
                            <h3>SVM 32×70i</h3>
                            <p>SVM 32×70i</p>
                            <div class="product-catalog-card__actions">
                                <a data-bs-toggle="modal" data-bs-target="#siteEnquiryForm" role="button"
                                    aria-label="Open enquiry form"
                                    class="product-catalog-card__cta product-catalog-card__cta--primary">Enquire Now</a>
                                <a href="https://wa.me/+971545864310?text=I%20am%20interested%20in%20Savema%20Feeders."
                                    target="_blank" rel="noopener"
                                    class="product-catalog-card__cta product-catalog-card__cta--secondary">WhatsApp
                                    Us</a>
                                <a href="product-detail.php" class="product-catalog-card__arrow"
                                    aria-label="View Savema Feeders details"> <svg xmlns="http://www.w3.org/2000/svg"
                                        width="11" height="11" viewBox="0 0 11 11" fill="none">
                                        <path
                                            d="M0.800176 9.85096L9.85114 0.799996M9.85114 0.799996L9.85114 7.58822M9.85114 0.799996L3.06292 0.799997"
                                            stroke="black" stroke-width="1.6" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg></a>
                            </div>
                        </div>
                    </article>
                    <article class="product-catalog-card">
                        <div class="product-catalog-card__image">
                            <img src="public/images/shop/15.png" alt="SVM 53x70i">
                        </div>
                        <div class="product-catalog-card__content">
                            <h3>TR 53×600</h3>
                            <p>TR 53×600</p>
                            <div class="product-catalog-card__actions">
                                <a data-bs-toggle="modal" data-bs-target="#siteEnquiryForm" role="button"
                                    aria-label="Open enquiry form"
                                    class="product-catalog-card__cta product-catalog-card__cta--primary">Enquire Now</a>
                                <a href="https://wa.me/+971545864310?text=I%20am%20interested%20in%20Savema%20Feeders."
                                    target="_blank" rel="noopener"
                                    class="product-catalog-card__cta product-catalog-card__cta--secondary">WhatsApp
                                    Us</a>
                                <a href="product-detail.php" class="product-catalog-card__arrow"
                                    aria-label="View Savema Feeders details"> <svg xmlns="http://www.w3.org/2000/svg"
                                        width="11" height="11" viewBox="0 0 11 11" fill="none">
                                        <path
                                            d="M0.800176 9.85096L9.85114 0.799996M9.85114 0.799996L9.85114 7.58822M9.85114 0.799996L3.06292 0.799997"
                                            stroke="black" stroke-width="1.6" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg></a>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>