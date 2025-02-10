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

    const testimonialSectionID = `sp-testimonial-free-wrapper-999`;
    

    const astraContentContainer = document.querySelector( astraContentContainerSelector );
    const contentAreaContainer = document.querySelector( contentAreaContainerSelector );

    const astraContentContainerStyleData = window.getComputedStyle( astraContentContainer );
    
    // const astContentContainerMarginLeft = astraContentContainerStyleData.getPropertyValue('margin-left');//OK - 126.667px. Expect 437.22px
    // const astContentContainerMarginRight = astraContentContainerStyleData.getPropertyValue('margin-right');//OK - 126.667px. Expect 437.22px
    
    let astContentContainerMarginLeft = astraContentContainerStyleData.marginLeft;//OK. Got 437.22px
    let astContentContainerMarginRight = astraContentContainerStyleData.marginRight;//OK. Got 437.22px

    astContentContainerMarginLeft = astContentContainerMarginLeft.substring(0, astContentContainerMarginLeft.length - 2 );//437.22 in string format

    // const astContentContainerPaddingLeft = astraContentContainerStyleData.getPropertyValue('padding-left');//OK - 20px
    // const astContentContainerPaddingRight = astraContentContainerStyleData.getPropertyValue('padding-right');//OK - 20px

    let astContentContainerPaddingLeft = astraContentContainerStyleData.paddingLeft;
    astContentContainerPaddingLeft = astContentContainerPaddingLeft.substring(0, astContentContainerPaddingLeft.length - 2 );// 20 in string format

    let astContentContainerPaddingRight = astraContentContainerStyleData.paddingRight;

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

    // console.log(`astContentContainerMarginLeft : ${astContentContainerMarginLeft}`);
    // console.log(`astContentContainerMarginRight : ${astContentContainerMarginRight}`);
    // console.log(`astContentContainerPaddingLeft : ${astContentContainerPaddingLeft}`);
    // console.log(`astContentContainerPaddingRight : ${astContentContainerPaddingRight}`);

});

