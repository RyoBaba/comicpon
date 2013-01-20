/**
 * html text parse
 */

function html_text_parse( str ) {
	str = str.replace(/[\n\r]/g, "");
	str = str.replace(/\<\!DOCTYPE.+\<body/, "");
	str = str.replace(/\/body.*$/, "");
	str = str.replace(/script/g, "div");
	return str;
}