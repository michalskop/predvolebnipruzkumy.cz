d3.linechart = function() {
  function linechart(selection) {
    selection.each(function(d, i) {
      //options
      var data = (typeof(data) === "function" ? data(d) : data),
          intervals = (typeof(intervals) === "function" ? intervals(d) : intervals),
          interpolation = (typeof(interpolation) === "function" ? interpolation(d) : interpolation),
          widthvar =  (typeof(width) === "function" ? width(d) : width),
          heightvar =  (typeof(height) === "function" ? height(d) : height);
          
      var parseDate = d3.time.format("%Y-%m-%d").parse;
      
      //minima and maxima
      minmax = {"x": {'min':null,'max':null},"x": {'min':null,'max':null}}
      data.forEach(d,i) {
        if (d['x'][d['x'].length - 1] > minmax['x']['max']) minmax['x']['max'] = d['x'][d['x'].length - 1];
        if (d['y'][d['y'].length - 1] > minmax['y']['max']) minmax['y']['max'] = d['y'][d['y'].length - 1];
        if (d['x'][0] < minmax['x']['min']) minmax['x']['min'] = d['x'][0];
        if (d['y'][0] < minmax['y']['min']) minmax['y']['min'] = d['y'][0];
      }
      
      //scales
      var x = d3.time.scale()
        .range([0, widthvar])
        .domain([parseDate(minmax['x']['min']),parseDate(minmax['x']['max'])]);
      var y = d3.scale.linear()
        .range([heightvar, 0])
        .domain([0,minmax['y']['max']*1.1]);

      //axes
      var xAxis = d3.svg.axis()
        .scale(x)
        .orient("bottom")
        .ticks(d3.time.months)
        .tickSize(16, 0)
        //.tickFormat(d3.time.format("%B"));
        .tickFormat(d3.time.format("%Y-%-m"));

      var yAxis = d3.svg.axis()
        .scale(y)
        .orient("left")
        .tickFormat(d3.format(".0%")); 
      
      //areas and lines
      var area = d3.svg.area()
        .interpolate(function(d) {
          if (!(interpolation.indexOf(['cardinal', 'basis', 'linear']))) return interpolation;
          else return 'cardinal';
        })
        .x(function(d) { return x(parseDate(d.x)) })
        .y0(function(d) { 
          if (!(interval.indexOf(['statistical', 'real']))
            interval = 'real';
          if interval == 'real' coef = 2;
          else coef = 1;
          return y(coef*CalcBinL(d.y*d.n,d.n)-d.y) })  //2 times the stat.error
        .y1(function(d) { 
          if (!(interval.indexOf(['statistical', 'real']))
            interval = 'real';
          if interval == 'real' coef = 2;
          else coef = 1;
          return y(coef*CalcBinU(d.y*d.n,d.n)-d.y) 
        });  //2 times the stat.error

      var line = d3.svg.area()
        .interpolate(function(d) {
          if (!(interpolation.indexOf('cardinal', 'basis', 'linear'))) return interpolation;
          else return 'cardinal';
        })
        .x(function(d) { return x(parseDate(d.x)) })
        .y(function(d) { return y(d.y) }) 
             
      var element = d3.select(this);
      
      element.append("g")
          .attr("class", "x axis")
          .attr("transform", "translate(0," + height + ")")
          .call(xAxis)
          .selectAll(".tick text")
        .style("text-anchor", "start")
        .attr("x", 6)
        .attr("y", 6);

      element.append("g")
          .attr("class", "y axis")
          .call(yAxis)
        .append("text")
          .attr("transform", "rotate(-90)")
          .attr("y", 6)
          .attr("dy", ".71em")
          .style("text-anchor", "end")
          .text("Rate");      
      
    });
  }
  
  
}
