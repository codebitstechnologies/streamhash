$(document).ready(function () {
    //Initialize tooltips
    $('.nav-tabs > li a[title]').tooltip();
    
    //Wizard
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

        var $target = $(e.target);
    
        if ($target.parent().hasClass('disabled')) {
            return false;
        }
    });

    $(".next-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        $active.next().removeClass('disabled');
        nextTab($active);

    });
    $(".prev-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        prevTab($active);

    });
});

function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}

/**
 * Function Name : saveVideoDetails()
 * To save first step of the job details
 * 
 * @var step        Step Position 1
 *
 * @return Json response
 */
function saveVideoDetails(step) {
   var title = $("#title").val();
   var datepicker = $("#datepicker").val();
   var duration = $("#duration").val();
   var rating = $("#rating").val();
   var description = $("#description").val();
   var reviews = $("#reviews").val();
   if (title == '') {
        alert('Title Should not be blank');
        return false;
   }
   if (datepicker == '') {
        alert('Publish Time Should not be blank');
        return false;
   }
   if (duration == '') {
        alert('Duration Should not be blank');
        return false;
   }
   if (rating == '') {
        alert('Ratings Should not be blank');
        return false;
   }
   if (description == '') {
        alert('Description Should not be blank');
        return false;
   }
   if (reviews == '') {
        alert('Reviews Should not be blank');
        return false;
   }
   $("#"+step).click();
}


/**
 * Function Name : saveCategory()
 * To save second step of the job details
 * 
 * @var category_id Category Id (Dynamic values)
 * @var step        Step Position 2
 *
 * @return Json response
 */
function saveCategory(category_id, step) {
    var categoryId = $("#category_id").val(category_id);
    displaySubCategory(category_id, step);
}

/**
 * Function Name : displaySubCategory()
 * To Display all sub categories based on category id
 *
 * @var category_id    Selected Category id
 * 
 * @return Json Response
 */
function displaySubCategory(category_id,step) {
    $("#sub_category").html("<p class='text-center'><i class='fa fa-spinner'></i></p>");
    $.ajax ({
        type : 'post',
        url : cat_url,
        data : {option: category_id},
        success : function(data) {
            $("#sub_category").html("");
            // console.log(data);return false;
            if (data == undefined) {
                alert("Oops Something went wrong. Kindly contact your administrator.");
                return false;
            }
            if (data.length == 0) {
                alert('No sub categories available. Kindly contact support team.');
                return false;
            }
            var subcategory = '';
            for(var i=0; i < data.length; i++) {
                var value = data[i];
                subcategory += '<div class="col-lg-4 col-md-4 col-sm-12 col-sx-12">'+
                                    '<a class="category-item text-center" onclick="saveSubCategory('+value.id+', '+step3+')">'+
                                        '<div class="category-img bg-img" '+
                                            ' style="background-image: url('+value.picture+')">'+
                                        '</div><h3 class="category-tit">'+value.name+'</h3>'+
                                    '</a>'+
                                '</div>';
            }
            $("#sub_category").append(subcategory);
            $("#"+step).click();
        },
        error : function(data) {
            alert("Oops Something went wrong. Kindly contact your administrator.");
        }
    });
}

/**
 * Function Name : saveSubCategory()
 * To save third step of the job details
 * 
 * @var sub_category_id     Sub Category Id (Dynamic values)
 * @var step                Step Position 3
 *
 * @return Json response
 */
function saveSubCategory(sub_category_id, step) {
    var subCategoryId = $("#sub_category_id").val(sub_category_id);
    $("#"+step).click();   
    // console.log(sub_cat_url);
    $.ajax ({
        type : 'post',
        url : sub_cat_url,
        data : {option: sub_category_id},
        success : function(data) {
            $('#genre').empty(); 

            $('#genre').append("<option value=''>Select genre</option>");

            if(data.length != 0) {
                $("#genre_id").show();
                document.getElementById("genre").disabled=false;
            } else {
                $("#genre_id").hide();
                document.getElementById("genre").disabled=true;
            }

            $.each(data, function(index, element) {
                $('#genre').append("<option value='"+ element.id +"'>" + element.name + "</option>");
            });
        },
        error : function(data) {
            alert("Oops Something went wrong. Kindly contact your administrator.");
        }
    });
}


function loadGenre() {
    var subCategoryId = $("#sub_category_id").val();
    // var genre_id = $("#genre").val();
    console.log(subCategoryId);
    $.ajax ({
        type : 'post',
        url : sub_cat_url,
        data : {option: subCategoryId},
        success : function(data) {
            console.log(data);
            $('#genre').empty(); 

            $('#genre').append("<option value=''>Select genre</option>");

            if(data.length != 0) {
                $("#genre_id").show();
                document.getElementById("genre").disabled=false;
            } else {
                $("#genre_id").hide();
                document.getElementById("genre").disabled=true;
            }

            $.each(data, function(index, element) {
                $('#genre').append("<option value='"+ element.id +"'>" + element.name + "</option>");
            });
            $("#genre").val(genreId);
        },
        error : function(data) {
            alert("Oops Something went wrong. Kindly contact your administrator.");
        }
    });
}


var bar = $('.bar');
var percent = $('.percent');



$('form').ajaxForm({
    beforeSend: function() {
        var percentVal = '0%';
        bar.width(percentVal)
        percent.html(percentVal);
        $("#"+final).text("Wait Progressing...");
        $("#"+final).attr('disabled', true);
    },
    uploadProgress: function(event, position, total, percentComplete) {
        console.log(total);
        console.log(position);
        console.log(event);
        var percentVal = percentComplete + '%';
        bar.width(percentVal)
        percent.html(percentVal);
        if (percentComplete == 100) {
            $("#"+final).text("Video Uploading...");
            $(".overlay").show();
            $("#"+final).attr('disabled', true);
        }
    },
    complete: function(xhr) {
        bar.width("100%");
        percent.html("100%");
        $(".overlay").show();
        $("#"+final).text("Redirecting...");
        $("#"+final).attr('disabled', true);
        console.log(xhr);
    },
    error : function(xhr) {
        alert(xhr);
    },
    success : function(xhr) {
        $("#"+final).text("Finished");
        $("#"+final).attr('disabled', false);
        $(".overlay").hide();
        if(xhr.id == '' && xhr.id == undefined) {
            alert(xhr);
        } else {
            window.location.href= xhr.id;
        }
    }
}); 

function loadFile(event, id){
    // alert(event.files[0]);
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById(id);
      // alert(output);
      output.src = reader.result;
       //$("#imagePreview").css("background-image", "url("+this.result+")");
    };
    reader.readAsDataURL(event.files[0]);
}