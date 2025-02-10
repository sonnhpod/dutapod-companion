document.addEventListener( 'DOMContentLoaded', function(){
    // Screen sizes variables - in pixel value
    const minXxlScreenWidth = 1400;

    const maxXlScreenWidth = 1399;
    const minXlScreenWidth = 1200;

    const maxLgScreenWidth = 1199;
    const minLgScreenWidth = 992;
    
    const maxMdScreenWidth = 991;
    const minMdScreenWidth = 768;
    
    const maxSmScreenWidth = 767;
    const minSmScreenWidth = 576;

    const maxXsScreenWidth = 575;

    const outermostContentContainerSelector = `div#content.site-content`;
    const astraContentContainerSelector = `${outermostContentContainerSelector} > div.ast-container`;
    const contentAreaContainerSelector = `${astraContentContainerSelector} > div#primary.content-area`;

    const heroSectionSelector = `${contentAreaContainerSelector} > main#main > article.page > div.entry-content > div.hero-section-image-container`;

    const testimonialSectionID = `sp-testimonial-free-wrapper-999`;
    const heroSectionID = `hero-section-image-id`;

    const astraContentContainer = document.querySelector( astraContentContainerSelector );
    const contentAreaContainer = document.querySelector( contentAreaContainerSelector );

    const astraContentContainerStyleData = window.getComputedStyle( astraContentContainer );
    
    // const astContentContainerMarginLeft = astraContentContainerStyleData.getPropertyValue('margin-left');//OK - 126.667px. Expect 437.22px
    // const astContentContainerMarginRight = astraContentContainerStyleData.getPropertyValue('margin-right');//OK - 126.667px. Expect 437.22px
    
    let astContentContainerMarginLeft = astraContentContainerStyleData.marginLeft;//OK. Got 437.22px
    astContentContainerMarginLeft = astContentContainerMarginLeft.substring(0, astContentContainerMarginLeft.length - 2 );//437.22 in string format

    let astContentContainerMarginRight = astraContentContainerStyleData.marginRight;//OK. Got 437.22px
    astContentContainerMarginRight = astContentContainerMarginRight.substring(0, astContentContainerMarginRight.length - 2 );//437.22 in string format


    // const astContentContainerPaddingLeft = astraContentContainerStyleData.getPropertyValue('padding-left');//OK - 20px
    // const astContentContainerPaddingRight = astraContentContainerStyleData.getPropertyValue('padding-right');//OK - 20px

    let astContentContainerPaddingLeft = astraContentContainerStyleData.paddingLeft;
    astContentContainerPaddingLeft = astContentContainerPaddingLeft.substring(0, astContentContainerPaddingLeft.length - 2 );// 20 in string format

    let astContentContainerPaddingRight = astraContentContainerStyleData.paddingRight;
    astContentContainerPaddingRight = astContentContainerPaddingRight.substring(0, astContentContainerPaddingRight.length - 2 );// 20 in string format

     /** 1. Add negative margin value to widen the size of the testimonial section - with the screen size >= md width */
    if( window.screen.width > minMdScreenWidth ){       
        const testimonialSection = document.getElementById( testimonialSectionID );

        let testimonialSectionWidth = testimonialSection.offsetWidth; // get testimonial Section 90vw width in pixel    

        let testimonialSectionScreenMarginLeft = 0.05 * window.screen.width; // 5vw - 5% view port width

        let testimonialSectionMarginLeft = parseFloat(astContentContainerMarginLeft) + parseFloat(astContentContainerPaddingLeft) - parseFloat( testimonialSectionScreenMarginLeft );
        testimonialSectionMarginLeft *= -1; 
        
        // Set negative margin left value 
        // testimonialSection.style.marginLeft = `-${testimonialSectionMarginLeft}px`;
        testimonialSection.style.marginLeft = `${testimonialSectionMarginLeft}px`;
    }    

    /** 2. Reposition the hero section in the mobile display */
    if( window.screen.width < maxXsScreenWidth ){
        // const heroSection = document.getElementById( heroSectionID );
        const heroSection = document.querySelector( heroSectionSelector ); //OK      
        
        const heroSectionData = window.getComputedStyle( heroSection );

        let originalHeroSectionMarginLeft = heroSectionData.marginLeft; // Expect 24px

        originalHeroSectionMarginLeft = originalHeroSectionMarginLeft.substring(0 , originalHeroSectionMarginLeft.length - 2 );

        // let updateHeroSectionMarginLeft = parseFloat(astContentContainerPaddingLeft) + parseFloat(originalHeroSectionMarginLeft);
        let updateHeroSectionMarginLeft = parseFloat(astContentContainerPaddingLeft) + parseFloat(astContentContainerMarginLeft);
        updateHeroSectionMarginLeft *= -1; 

        heroSection.style.marginLeft = `${updateHeroSectionMarginLeft}px`;

        // astContentContainerMarginLeft
        // div.hero-section-image-id - heroSectionMarginLeft
    }

    /** 3. Lazy load the best_selling_products shortcode */
    let lazyBestSellingProductsLoaded = false;

    const bestSellingProductsSection = document.getElementById( 'best-selling-products-lazy-load-container-id' );

    if( ! bestSellingProductsSection ) return;

    const bsProductsSectionObserver = new IntersectionObserver( ( entries, observer ) => {
        entries.forEach( entry => {
            if( entry.isIntersecting && ! lazyBestSellingProductsLoaded ){
                lazyBestSellingProductsLoaded = true;

                // Show a loading indicator
                // bestSellingProductsSection.innerHTML = `<div class="loading-spinner">Loading products ...</div>`;

                // Fetch best selling products data via AJAX
                // return response OK. Contain dedicated data
                fetch( woocommerce_params.ajax_url + "?action=load_lazy_best_selling_products" )
                    .then( response => response.json())
                    .then( responseData => {
                        // responseData is OK
                        if( responseData.success ){
                            // bestSellingProductsSection.innerHTML = responseData.data.html;//OK
                            bestSellingProductsSection.innerHTML = `<div class="lazy-load-best-selling-products-outer-container">${responseData.data.html}</div>`;

                            // Ensure the fade-in effect is applied after DOM update
                            requestAnimationFrame( () => {
                                const bestSellingProductsOuterContainer = document.querySelector( 'div.lazy-load-best-selling-products-outer-container' );
                                bestSellingProductsOuterContainer.classList.add('fade-in');
                            } );
                        } else {
                            bestSellingProductsSection.innerHTML = `<p>Error loading products. There is no data success </p>`;
                        }
                    })
                    .catch( error => {
                        bestSellingProductsSection.innerHTML = `<p>Error loading products at Fetch API Catch statement ! ... </p>`;
                        console.error('Detail error message is :');
                        console.error( error );
                    });
                
                observer.unobserve( bestSellingProductsSection );
            }
        });
    }, { threshold: 0.2 } ); //Trigger when 20% of the section is visible

    bsProductsSectionObserver.observe( bestSellingProductsSection );
    // console.log(`astContentContainerMarginLeft : ${astContentContainerMarginLeft}`);
    // console.log(`astContentContainerMarginRight : ${astContentContainerMarginRight}`);
    // console.log(`astContentContainerPaddingLeft : ${astContentContainerPaddingLeft}`);
    // console.log(`astContentContainerPaddingRight : ${astContentContainerPaddingRight}`);

});

