   <!-- carousel -->
    <div class="carousel container mb-3">
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="<?= base_url() ?>assets/sepatu.jpg" class="d-block w-100" alt="Shoes">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Shoes</h5>
                        <p style="color: lightyellow;">Men's stylish shoes for every occasion.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="<?= base_url() ?>assets/analog-watch.jpg" class="d-block w-100" alt="Watch">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Luxury Watch</h5>
                        <p style="color: lightyellow;">Perfect blend of style and precision.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="<?= base_url() ?>assets/tas.jpg" class="d-block w-100" alt="Leather Bag">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Leather Bag</h5>
                        <p style="color: lightyellow;">Elegant leather bags for your journey.</p>
                    </div>
                </div>
            </div>
            
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>