$(document).ready(function () {

    // Add course
    $('#addCourse').click(function () {
        let row = $('.course-row').first().clone();
        row.find('input').val('');
        $('#courses').append(row);
    });

    // Submit form
    $('#gpaForm').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: 'calculate.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',

            success: function (response) {

                if (response.success) {

                    let html = `<h3>GPA: ${response.gpa.toFixed(2)}</h3>`;

                    html += `<h4>History</h4><ul>`;

                    response.history.forEach(item => {
                        html += `<li>
                            ${item.student} | ${item.semester}
                            → GPA: ${item.gpa}
                            (${item.time})
                        </li>`;
                    });

                    html += `</ul>`;

                    $('#result').html(html);

                } else {
                    $('#result').html(`<p>${response.message}</p>`);
                }
            }
        });
    });

});
