<div class="landing-slider">

    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <div class="carousel-slide carousel-slide-1">
            <div class="slide-info">
              <h2 class="slide-top_heading">
                Top Smartwatches
              </h2>
              <h1 class="slide-main_heading">
                Wonderful Performance
              </h1>
              <p class="slide-description">
                  {{ Str::limit($product20->title, 100) }}
              </p>
              <button class="button button_buy-now" onclick="window.location='{{ route('product-detail',['slug' => $product20->slug, 'sku' => $product20->sku]) }}'" >
                <span class="button-price">{{number_format((float)$product20->retail_price, 2, '.', '')}}$</span>
                <span class="button-text">BUY NOW</span>
              </button>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <div class="carousel-slide ">
            <div class="carousel-slide-filter"></div>
            <div class="carousel-slide carousel-slide-2">
              <div class="slide-info">
                <h2 class="slide-top_heading">
                  Top Gadgets
                </h2>
                <h1 class="slide-main_heading">
                  Most Reliable
                </h1>
                <p class="slide-description">
                    {{ Str::limit($product21->title, 100) }}
                </p>
                <button class="button button_buy-now" onclick="window.location='{{ route('product-detail',['slug' => $product21->slug, 'sku' => $product21->sku]) }}'" >
                    <span class="button-price">{{number_format((float)$product21->retail_price, 2, '.', '')}}$</span>
                    <span class="button-text">BUY NOW</span>
                  </button>
              </div>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <div class="carousel-slide ">
          <div class="carousel-slide-filter"></div>
            <div class="carousel-slide carousel-slide-3">
              <div class="slide-info">
                <h2 class="slide-top_heading">
                  Top Home Accessories
                </h2>
                <h1 class="slide-main_heading">
                  Most Beautiful
                </h1>
                <p class="slide-description">
                    {{ Str::limit($product22->title, 100) }}
                </p>
                <button class="button button_buy-now" onclick="window.location='{{ route('product-detail',['slug' => $product22->slug, 'sku' => $product22->sku]) }}'" >
                    <span class="button-price">{{number_format((float)$product22->retail_price, 2, '.', '')}}$</span>
                    <span class="button-text">BUY NOW</span>
                  </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </div>

</div>
