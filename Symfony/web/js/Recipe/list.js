/**
 * This file is related to the view list.html.twig.
 * @author jhumbert
 */
$(function() {
    //------------Variable initialisation--------------------------------------
	var page = 1;;
	var categories = "All";
	var sorter = "title";
    var direction = "ASC";

	var uri = $("#body-list").data("uri");
	var uriShow = $("#body-list").data("uri-show").split('0')[1];
	var $layer = $("#layer-recipe-item");
	var last_page = $('.pagination > li:last-child > a').data('page');
    var li_list = $('.pagination > li');

    //---------Page loading Logic----------------------------------------------
    $.get(generateUri(), add_list_items);
	update_pagination();

    //----------Event for pagination------------------------------------------
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

			update_list();
		}
	});

    //----------Events for sorting---------------------------------------------
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

    /*
     * Generate the URI to call via AJAX.
     */
    function generateUri() {
        console.log(uri + '/' + sorter + '/' + page + '/' + direction + '/' + categories);
        return uri +
            '/' + sorter +
            '/' + page +
            '/' + direction +
            '/' + categories
        ;
    }

    /*
     * Adds the new items to the list
     */
	function add_list_items(data) {
        //TODO add an error handling and a loading.
		var recipes = data.recipes;

		for (var i = 0; i < recipes.length; i++) {
            add_item_to_list(recipes[i], i);
		}


        update_pagination();
	}

    /*
     * Add a entry in the list
     * @param row the number of the row
     */
    function add_item_to_list(recipe, row) {
        var $item = $layer.clone();
        var time = recipe.duration.date.split(" ")[1].split(":");

        $item.attr('id', "recipe-item-" + row)
            .attr('class', 'recipe-item');
        $item.find(".recipe-title > a")
            .text(recipe.title)
            .attr("href", uriShow + recipe.slug);
        $item.find(".recipe-category")
            .text(recipe.category);
        $item.find(".recipe-duration")
            .text(time[0] + ' h ' + time[1]);
        $item.find(".recipe-rating")
            .text(recipe.rating);
        $("#body-list").append($item);
    }

    /*
     * Update the pagination (disable/enable links, update the number of the page, show if hidden)
     */
	function update_pagination() {
        update_allowed_pagination();
		$('.pagination').show();
        $('.pagination > li > a.current').text(page).data('page', page);
	}

    /*
     * Updates the attribute disabled on the pagination link.
     */
    function update_allowed_pagination() {
        if (last_page == 1) {
            $(li_list[0]).addClass('disabled');
			$(li_list[1]).addClass('disabled');
			$(li_list[3]).addClass('disabled');
			$(li_list[4]).addClass('disabled');
        } else if (page == 1) {
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

    /*
     * Initialise the new sorting, by changing the direction if the sorter is the same as previously
     */
    function initialiseChangeSort(newSorter) {
        if (direction != "ASC" || sorter != newSorter)
            direction = "ASC";
        else
            direction = "DESC";
        sorter = newSorter;
        page = 1;
        update_list();
    }

    /*
     * Update the list by removing all the current items, before adding the new ones
     */
    function update_list() {
        $("#body-list").find('tr.recipe-item').remove();
        $.get(generateUri(), add_list_items);
    }


});
