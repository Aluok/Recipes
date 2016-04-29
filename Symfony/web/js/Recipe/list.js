/**
 * This file is related to the view list.html.twig.
 * @author jhumbert
 */
$(function() {
    //------------Variable initialisation--------------------------------------
	var page = 1;;
	var sorter = "title";
    var direction = "ASC";

	var uri = $("#body-list").data("uri");
	var uriShow = $("#body-list").data("uri-show").split('0')[1];
	var $layer = $("#layer-recipe-item");
	var lastPage = $('.pagination > li:last-child > a').data('page');
    var liList = $('.pagination > li');
    var filters = {
        'categories': [],
        'ingredients': [],
        'add': function(filter, value) {
            if (this[filter].indexOf(value) == -1) {
                this[filter].push(value);
            }
        },
        'remove': function(filter, value) {
            var index = this[filter].indexOf(value);
            if (index != -1) {
                this[filter].splice(index, 1);
            }
        },
    }

    //---------Page loading Logic----------------------------------------------
    $.get(generateUri(), add_list_items);
	update_pagination();
    show_sort_marker('title');
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
				page = lastPage;
				break;
			}

			update_list();
		}
	});

    //----------Event for sorting---------------------------------------------
	$('.sort').on('click', function() {
        initialiseChangeSort($(this).data('sorter'));
	});

    //----------Event for filtering--------------------------------------------
    $('.filter-list input').on('change', function() {
        initialiseChangeFilter($(this));
    });

    /*
     * Generate the URI to call via AJAX.
     */
    function generateUri() {
        var url = uri +
            '/' + sorter +
            '/' + page +
            '/' + direction
        ;
        var empty = true;
        for (filter in filters) {
            if (filter.length != 0)
                empty = false;
        }
        if (empty)
            url += '/All';
        else {
            if (filters.categories.length != 0)
                url += '/category=' + filters.categories.join('_');
            if (filters.ingredients.length != 0)
                url += '/ingredients=' + filters.ingredients.join('_');
        }
        return url;
    }

    /*
     * Adds the new items to the list
     */
	function add_list_items(data) {
		var recipes = data.recipes;

		for (var i = 0; i < recipes.length; i++) {
            add_item_to_list(recipes[i], i);
		}

        update_pagination(data.totalPages);
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
	function update_pagination(nbPages) {
        lastPage = nbPages;
        update_allowed_pagination();
		$('.pagination').show();
        $('.pagination > li > a.current').text(page).data('page', page);
	}

    /*
     * Updates the attribute disabled on the pagination link.
     */
    function update_allowed_pagination() {
        if (lastPage == 1) {
            $(liList[0]).addClass('disabled');
			$(liList[1]).addClass('disabled');
			$(liList[3]).addClass('disabled');
			$(liList[4]).addClass('disabled');
        } else if (page == 1) {
			$(liList[0]).addClass('disabled');
			$(liList[1]).addClass('disabled');
			$(liList[3]).removeClass('disabled');
			$(liList[4]).removeClass('disabled');
		} else if (page == lastPage) {
			$(liList[0]).removeClass('disabled');
			$(liList[1]).removeClass('disabled');
			$(liList[3]).addClass('disabled');
			$(liList[4]).addClass('disabled');
		} else {
			$(liList[0]).removeClass('disabled');
			$(liList[1]).removeClass('disabled');
			$(liList[3]).removeClass('disabled');
			$(liList[4]).removeClass('disabled');
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
        show_sort_marker(newSorter);
    }

    /*
     * Update the list by removing all the current items, before adding the new ones
     */
    function update_list() {
        $("#body-list").find('tr.recipe-item').remove();
        $.get(generateUri(), add_list_items);
    }

    function show_sort_marker(marker) {
        $('.sort .glyphicon').hide();

        if (direction == 'ASC')
            var className = 'glyphicon-menu-down';
        else
            var className = 'glyphicon-menu-up';
        $('#' + marker + '-recipe .' + className).show();
    }
    //TODO update last page.
    //TODO include filter in pagination and sort

    function initialiseChangeFilter($item) {
        var filter = $item.closest('.filter-list').data('filter')
        //We update the list of all current filters.
        if ($item.prop('checked')) {
            filters.add(filter, $item.val());
        } else {
            filters.remove(filter, $item.val());
        }
        //we keep the current sort, but get back to page 1.
        page = 1;
        //we send the request and update the list
        update_list();
        //We update the list
    }
});
