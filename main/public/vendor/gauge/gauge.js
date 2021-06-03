
$(function() {
    "use strict";

// ============================================================== 
    // Guage 2
    // ============================================================== 




    var opts3 = {
        angle: 0.35, // The span of the gauge arc
        lineWidth: 0.1, // The line thickness
        radiusScale: 1, // Relative radius
        pointer: {
            length: 0.6, // // Relative to gauge radius
            strokeWidth: 0.115, // The thickness
            color: '#2e2f39' // Fill color
        },
        limitMax: false, // If false, max value increases automatically if value > maxValue
        limitMin: false, // If true, the min value of the gauge will be fixed
        colorStart: '#6dff1b', // Colors
        colorStop: '#06ff00', // just experiment with them
        strokeColor: '#e4e4ee', // to see which ones work best for you
        generateGradient: true,
        highDpiSupport: true, // High resolution support
        // renderTicks is Optional
        renderTicks: {
            divisions: 5,
            divWidth: 1.1,
            divLength: 0.7,
            divColor: '#333333',
            subDivisions: 3,
            subLength: 0.5,
            subWidth: 0.6,
            subColor: '#666666'
        }

    };
    var target3 = document.getElementById('gauge3'); // your canvas element
    var gauge3 = new Donut(target3).setOptions(opts3); // create sexy gauge!
    gauge3.maxValue = 3000; // set max gauge value
    gauge3.setMinValue(0); // Prefer setter over gauge.minValue = 0
    gauge3.animationSpeed = 32; // set animation speed (32 is default value)
    gauge3.set(1675); // set actual value




});



