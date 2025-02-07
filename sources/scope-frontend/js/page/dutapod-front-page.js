document.addEventListener('DOMContentLoaded', function(){
    const outermostContentContainerSelector = `div#content.site-content`;
    const astraContentContainerSelector = `${outermostContentContainerSelector} > div.ast-container`;
    const astraContentContainer = document.querySelector( astraContentContainerSelector );

    const astraContentContainerStyleData = window.getComputedStyle( astraContentContainer );
    const astContentContainerMarginLeft = astraContentContainerStyleData.getPropertyValue('margin-left');//OK
    const astContentContainerMarginRight = astraContentContainerStyleData.getPropertyValue('margin-right');//OK
    const astContentContainerPaddingLeft = astraContentContainerStyleData.getPropertyValue('padding-left');//OK
    const astContentContainerPaddingRight = astraContentContainerStyleData.getPropertyValue('padding-right');//OK

    // console.log(`astContentContainerMarginLeft : ${astContentContainerMarginLeft}`);
    // console.log(`astContentContainerMarginRight : ${astContentContainerMarginRight}`);
    // console.log(`astContentContainerPaddingLeft : ${astContentContainerPaddingLeft}`);
    // console.log(`astContentContainerPaddingRight : ${astContentContainerPaddingRight}`);

});

