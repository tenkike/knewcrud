<div class="container px-4 py-5 " id="custom-cards">
    <h2 class="pb-2 border-bottom">Custom cards</h2>
     <div class="row row-cols-1 row-cols-md-3 align-items-stretch g-4 py-5">

<?php for($i=0; $i < 3; $i++): ?>
   
      <div class="col">
        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-md" style="background-image: url('unsplash-photo-1.jpg');">
          <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
            <h2 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Short title, long jacket</h2>
            <ul class="d-flex list-unstyled mt-auto">
              <li class="me-auto">
                <img src="https://github.com/twbs.png" alt="Bootstrap" class="rounded-circle border border-white" width="32" height="32">
              </li>
              <li class="d-flex align-items-center me-3">
                <svg class="bi me-2" width="1em" height="1em"><use xlink:href="#geo-fill"></use></svg>
                <small>Earth</small>
              </li>
              <li class="d-flex align-items-center">
                <svg class="bi me-2" width="1em" height="1em"><use xlink:href="#calendar3"></use></svg>
                <small>3d</small>
              </li>
            </ul>
          </div>
        </div>
      </div>
     <?php endfor; ?>
    </div>
  </div><?php /**PATH /var/www/html/knewsweb.org/resources/views/pages/section_1.blade.php ENDPATH**/ ?>