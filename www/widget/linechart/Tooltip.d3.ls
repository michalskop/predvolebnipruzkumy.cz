window.Tooltip = class Tooltip
    @counter = 0
    (@options = {}) ->
        @eventId = "tooltip-#{@@counter++}"
        @options.parent ?= d3.select 'body'
        d3.select document .on "mousemove.#{@eventId}" @~onMouseMove

    watchElements: ->
        d3.select document .on "mouseover.#{@eventId}" ~>
            currentTarget = d3.event.target
            do
                content = currentTarget.getAttribute \data-tooltip
                currentTarget = currentTarget.parentNode
            while currentTarget isnt document and content is null
            return if not content
            content = unescape content
            return if not content.length
            @display content

        d3.select document .on "mouseout.#{@eventId}" @~hide

    display: (content) ->
        @$element = @options.parent.append \div
            ..attr \class \tooltip
            ..html content

        @setPositionByMouse!

    hide: ->
        return if not @$element
        @$element.remove!
        @$element = null
        @mouseBound = false

    reposition: ([left, top, clientLeft, clientTop]) ->
        dX = left - clientLeft
        dY = top - clientTop
        element = @$element.0.0
        width = element.offsetWidth
        left -= width / 2
        maxLeft = (window.innerWidth || document.documentElement.clientWidth) - width
        top -= element.offsetHeight
        left = Math.max dX, left
        left = Math.min left, dX + maxLeft
        if top <= 19 + dY
            topMargin = -20
            top += element.offsetHeight - 2 * topMargin
        @$element
            ..style 'left' "#{left}px"
            ..style 'top' "#{top}px"


    setPositionByMouse: ->
        @mouseBound = true
        @reposition @lastMousePosition if @lastMousePosition

    onMouseMove: ~>
        evt = d3.event
        @lastMousePosition =
            evt.pageX || evt.clientX
            evt.pageY || evt.clientY
            evt.clientX
            evt.clientY
        if @mouseBound then @reposition @lastMousePosition
