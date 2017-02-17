
var Message = React.createClass({
    
    
    render: function(){
        jojo = React.createElement("h1",null,"Hello");
        hoho = React.createElement("h2",null,"next hello");
        
        return React.createElement("h1" ,null, this.props.title);
    }
});
