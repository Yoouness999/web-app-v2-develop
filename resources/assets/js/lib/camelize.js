export default function (string) {
    string = string.replace(/[\-_\s]+(.)?/g, (match, chr) => chr ? chr.toUpperCase() : '');
    // Ensure 1st char is always lowercase
    return string.substr(0, 1).toLowerCase() + string.substr(1);
}