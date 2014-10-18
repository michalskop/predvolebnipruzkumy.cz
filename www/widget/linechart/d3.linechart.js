d3.linechart = function() {
  function linechart(selection) {
    selection.each(function(d, i) {
      //options
      var data = (typeof(data) === "function" ? data(d) : d.data),
          intervals = (typeof(intervals) === "function" ? intervals(d) : d.intervals),
          interpolation = (typeof(interpolation) === "function" ? interpolation(d) : d.interpolation),
          widthvar =  (typeof(width) === "function" ? width(d) : d.width),
          heightvar =  (typeof(height) === "function" ? height(d) : d.height);
          
      var parseDate = d3.time.format("%Y-%m-%d").parse;
      
      //minima and maxima
      var minmax = {"x": {'min':'5000-01-01','max':'1000-01-01'},"y": {'min':1,'max':0}};
      data.forEach(function(d,i) {
        d['values'].forEach(function(dd,ii) {
          if (d['values'][ii]['y'] > minmax['y']['max']) minmax['y']['max'] = d['values'][ii]['y'];
          if (d['values'][ii]['y'] < minmax['y']['min']) minmax['y']['min'] = d['values'][ii]['y'];
          
        });
        if (d['values'][d['values'].length-1]['x'] > minmax['x']['max']) minmax['x']['max'] = d['values'][d['values'].length-1]['x'];
        if (d['values'][0]['x'] < minmax['x']['min']) minmax['x']['min'] = d['values'][0]['x'];
      });
 
      var margin = {top: 20, right: 80, bottom: 30, left: 50},
            width = widthvar - margin.left - margin.right,
            height = heightvar - margin.top - margin.bottom;
      
      //scales
      var x = d3.time.scale()
        .range([0, width])
        .domain([parseDate(minmax['x']['min']),parseDate(minmax['x']['max'])]);
      var y = d3.scale.linear()
        .range([height, 0])
        .domain([0,minmax['y']['max']*1.1]);

      //axes
      var xAxis = d3.svg.axis()
        .scale(x)
        .orient("bottom")
        .ticks(d3.time.years)
        .tickSize(16, 0)
        //.tickFormat(d3.time.format("%B"));
        .tickFormat(d3.time.format("%Y-%m"));

      var yAxis = d3.svg.axis()
        .scale(y)
        .orient("left")
        .tickFormat(d3.format(".0%")); 
      
      //areas and lines
      var area = d3.svg.area()
        .interpolate("cardinal")
        .x(function(d) { return x(parseDate(d.x)) })
        .y0(function(d) { 
          if (!(intervals.indexOf(['statistical', 'real']))) {
            intervals = 'real';
          }
          if (intervals == 'real') { coef = 2;}
          else {coef = 1;}
          return y(coef*CalcBinL(d.y*d.n,d.n)-(coef-1)*d.y) })  //2 times the stat.error
        .y1(function(d) { 
          if (!(intervals.indexOf(['statistical', 'real'])))
            intervals = 'real';
          if (intervals == 'real') coef = 2;
          else coef = 1;
          return y(coef*CalcBinU(d.y*d.n,d.n)-(coef-1)*d.y) 
        });  //2 times the stat.error

      var line = d3.svg.area()
        .interpolate("cardinal")
        .x(function(d) { return x(parseDate(d.x)) })
        .y(function(d) { return y(d.y) }) 
             
      var element = d3.select(this);

      var g = element.append("g")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
      .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
      
      g.append("g")
          .attr("class", "x axis")
          .attr("transform", "translate(0," + height + ")")
          .call(xAxis)
          .selectAll(".tick text")
        .style("text-anchor", "start")
        .attr("x", 6)
        .attr("y", 6);

      g.append("g")
          .attr("class", "y axis")
          .call(yAxis)
        .append("text")
          .attr("transform", "rotate(-90)")
          .attr("y", 6)
          .attr("dy", ".71em")
          .style("text-anchor", "end")
          .text("Rate");
          
      // interval
      g.selectAll(".band")
         .data(data)
        .enter().append("path")
         .attr("d",function(d) {
           nothing = 0;
           return area(d.values)
           })
         .attr("class","area")
         .attr("id",function(d) {return d.name + "-band"})
         .style("fill",function(d) {return d.properties.fill})
         .style("fill-opacity",0.2)
         .attr("title",function(d) {return d.name});              
      // line   
      g.selectAll(".line")
         .data(data)
       .enter().append("path")
         .attr("d",function(d) {return line(d.values)})
         .attr("class","line")
         .attr("id",function(d) {return d.name + "-line"})
         .style("stroke",function(d) {return d.properties.fill})
         .style("stroke-opacity",1)
         .attr("title",function(d) {return d.name});
         
      // points
      data.forEach(function(dat,i) {
          g.selectAll(".point")
              .data(dat.values)
            .enter().append("circle")
              .attr("cx", function(d) {
                nothing = 0;
                return x(parseDate(d.x)) 
              })
              .attr("cy", function(d) {return y(d.y) })
              .attr("r", 3)
              .style("stroke",function(d) {return dat.properties.fill})
              .style("stroke-width","3px")
              .style("fill","none");
      });
    });
  }
  
  
  
  linechart.data = function(value) {
    if (!arguments.length) return value;
    data = value;
    return linechart;
  };
  linechart.intervals = function(value) {
    if (!arguments.length) return value;
    intervals = value;
    return linechart;
  };
  linechart.interpolation = function(value) {
    if (!arguments.length) return value;
    interpolation = value;
    return linechart;
  };
  linechart.width = function(value) {
    if (!arguments.length) return value;
    width = value;
    return linechart;
  };
  linechart.height = function(value) {
    if (!arguments.length) return value;
    height = value;
    return linechart;
  };
  
  return linechart;
}
