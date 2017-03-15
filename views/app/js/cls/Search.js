class Search {
  constructor(keyword,category,byColor,color,sort) {
    this.params = {
      'keyword' : keyword.trim() || false,
      'category' : (category != 0) ? category : false,
      'color' : (byColor) ? (color.replace('#','')) : false,
      'sort' : (sort != 0) ? sort : false
    }
  }

  execute(page = 1){
    let getParams = '';
    for (let p in this.params){
      if(this.params[p]){
          getParams += `&${p}=${this.params[p]}`;
      }
    }
    window.location.assign(`?view=search${getParams}&page=${page}`);
  }
}
