function genPDF(){
    var img;
    html2canvas(document.getElementById("section")).then(
        function (canvas){
            img = canvas.toDataURL("image/png");
            var doc =new jsPDF('p', 'mm', 'a4');
            doc.addImage(img,'PNG', 1, 0, 208, 0);
            // doc.addPage();
            doc.save('report.pdf');

        }
    )
    // doc.text("Blood Link Report!", 90, 5);
}


function generatePDF() {
    // Create a new jsPDF object
    // var doc = new jsPDF();

    // Loop through each div element
    //var divs = document.getElementById('section');
    const popularBookingTypesContainer = document.getElementById('popular-booking-types');

    // var style = window.getComputedStyle(divs);
    // var fontSize = parseInt(style.getPropertyValue('font-size'));
    // var fontStyle = style.getPropertyValue('font-style');
    // doc.setFontSize(fontSize).setFontStyle(fontStyle);

    html2canvas(document.getElementById("report-section"))
        .then(
        function (canvas){
            const img = canvas.toDataURL("image/png");
            var doc = new jsPDF('p', 'mm', 'a4');
            doc.addImage(img,'PNG', 1, 0, 208, 0);
            // doc.addPage();
            doc.save('popular-booking-types.pdf');

        }
    );


    // Add the HTML content to the PDF
    //doc.fromHTML(popularBookingTypesContainer.innerHTML);

    // Add a page break after each div (except the last one)

    // Save the PDF document
    //doc.save('document.pdf');
}

