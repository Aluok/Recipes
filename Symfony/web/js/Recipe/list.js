/**
 *
 */
$(function() {
	var page = 1;;
	var categories = "All";
	var sorter = "title";
    var direction = "ASC";

	var uri = $("#body-list").data("uri");
	var uriShow = $("#body-list").data("uri-show").split('0')[1];
	var $layer = $("#layer-recipe-item");
	var last_page = $('.pagination > li:last-child > a').data('page');
    var li_list = $('.pagination > li');
	$.get(generateUri(), update_list);

	update_pagination();

	$('.pagination > li > a').on('click', function(e) {
		e.preventDefault();
		var classname = $(this).closest('li').attr('class');
		if (classname == undefined || classname.indexOf('disabled') == -1) {

			switch ($(this).data('action')) {
			case 'first':
				page = 1;
				break;
			case 'previous':
				page--;
				break;
			case 'next':
				page++;
				break;
			case 'last':
				page = last_page;
				break;
			}



			clean_list();
			$.get(uri + "/" + sorter + '/' + page + '/' + categories, update_list);
		}
	});

	$('#title-recipe').on('click', function() {
        initialiseChangeSort("title");
	});
	$('#category-recipe').on('click', function() {
        initialiseChangeSort("category");
	});
	$('#duration-recipe').on('click', function() {
        initialiseChangeSort("duration");
	});
	$('#rating-recipe').on('click', function() {
        initialiseChangeSort("rating");
	});


	function clean_list() {
		$("#body-list").find('tr.recipe-item').remove();
	}

	function update_list(data) {
		var recipes = data.recipes;
		for (var i = 0; i < recipes.length; i++) {
			var $item = $layer.clone();
			$item.attr('id', "recipe-item-" + i)
				.attr('class', 'recipe-item');
			$item.find(".recipe-title > a")
				.text(recipes[i].title)
				.attr("href", uriShow + recipes[i].slug);
			$item.find(".recipe-category")
				.text(recipes[i].category);
			var time = recipes[i].duration.date.split(" ")[1].split(":");
			$item.find(".recipe-duration")
				.text(time[0] + ' h ' + time[1]);
			$item.find(".recipe-rating")
				.text(recipes[i].rating);
			$("#body-list").append($item);
		}

		$('.pagination > li > a.current').text(page).data('page', page);
		if (page == 1) {
			$(li_list[0]).addClass('disabled');
			$(li_list[1]).addClass('disabled');
			$(li_list[3]).removeClass('disabled');
			$(li_list[4]).removeClass('disabled');
		} else if (page == last_page) {
			$(li_list[0]).removeClass('disabled');
			$(li_list[1]).removeClass('disabled');
			$(li_list[3]).addClass('disabled');
			$(li_list[4]).addClass('disabled');
		} else {
			$(li_list[0]).removeClass('disabled');
			$(li_list[1]).removeClass('disabled');
			$(li_list[3]).removeClass('disabled');
			$(li_list[4]).removeClass('disabled');
		}
	}

	function update_pagination() {
		$('.pagination').show();
		$('.pagination .current').text($("#body-list").data("page"));
	}

    function generateUri() {
        return uri +
            '/' + sorter +
            '/' + page +
            '/' + direction +
            '/' + categories
        ;
    }

    function initialiseChangeSort(newSorter) {
        if (direction != "ASC" || sorter != newSorter)
            direction = "ASC";
        else
            direction = "DESC";
        sorter = newSorter;
		page = 1;
		clean_list();
		$.get(generateUri(), update_list);
    }

});
