function sliderComparison(selector)
{
	var $el = jQuery(selector);

	checkPosition($el);

	jQuery(window).on('scroll', function(){
		checkPosition($el);
	});

	$el.each(function(){
		var actual = jQuery(this);
		drags(actual.find('.cd-handle'), actual.find('.cd-resize-img'), actual, actual.find('.cd-image-label[data-type="original"]'), actual.find('.cd-image-label[data-type="modified"]'));
	});

	jQuery(window).on('resize', function(){
		$el.each(function(){
			var actual = jQuery(this);
			updateLabel(actual.find('.cd-image-label[data-type="modified"]'), actual.find('.cd-resize-img'), 'left');
			updateLabel(actual.find('.cd-image-label[data-type="original"]'), actual.find('.cd-resize-img'), 'right');
		});
	});
}

function checkPosition(container) {
	container.each(function(){
		var actualContainer = jQuery(this);
		if( jQuery(window).scrollTop() + jQuery(window).height()*0.5 > actualContainer.offset().top) {
			actualContainer.addClass('is-visible');
		}
	});
}

//draggable funtionality - credits to http://css-tricks.com/snippets/jquery/draggable-without-jquery-ui/
function drags(dragElement, resizeElement, container, labelContainer, labelResizeElement) {
    var $ = jQuery;

    dragElement.on('mousedown vmousedown', function (e) {
        dragElement.addClass('cd-draggable');
        resizeElement.addClass('cd-resizable');

        var dragWidth = dragElement.outerWidth(),
            xPosition = dragElement.offset().left + dragWidth - e.pageX,
            containerOffset = container.offset().left,
            containerWidth = container.outerWidth(),
            minLeft = containerOffset + 10,
            maxLeft = containerOffset + containerWidth - dragWidth - 10;

        dragElement.parent().bind('mousemove.cd vmousemove.cd', function (e) {
            var leftValue = e.pageX + xPosition - dragWidth;

            // constrain the draggable element to move inside his container
            if (leftValue < minLeft) {
                leftValue = minLeft;
            } else if (leftValue > maxLeft) {
                leftValue = maxLeft;
            }

            var widthValue = (leftValue + dragWidth / 2 - containerOffset) * 100 / containerWidth + '%';

            $('.cd-draggable', container).css('left', widthValue).one('mouseup vmouseup', function () {
                $(this).removeClass('cd-draggable');
                resizeElement.removeClass('cd-resizable');
            });

            $('.cd-resizable', container).css('width', widthValue);

            updateLabel(labelResizeElement, resizeElement, 'left');
            updateLabel(labelContainer, resizeElement, 'right');

        }).one('mouseup vmouseup', function (e) {
            dragElement.removeClass('cd-draggable');
            resizeElement.removeClass('cd-resizable');

            dragElement.parent().unbind('mousemove.cd vmousemove.cd');
        });

        e.preventDefault();

    }).on('mouseup vmouseup', function (e) {
        dragElement.removeClass('cd-draggable');
        resizeElement.removeClass('cd-resizable');
    });
}

function updateLabel(label, resizeElement, position) {
	if(position == 'left') {
		( label.offset().left + label.outerWidth() < resizeElement.offset().left + resizeElement.outerWidth() ) ? label.removeClass('is-hidden') : label.addClass('is-hidden') ;
	} else {
		( label.offset().left > resizeElement.offset().left + resizeElement.outerWidth() ) ? label.removeClass('is-hidden') : label.addClass('is-hidden') ;
	}
}