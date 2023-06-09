$(function(){
    

    var str = '';
    function addmsg(str) {document.getElementById("msg").innerHTML += ", "+str;}
    function setmsg(str) {document.getElementById("msg").innerHTML = str;}

    //window.onerror = function(m, u, l){ addmsg(m+" at line "+l); return true;};
    // Create the spreadsheet control, but don't initialize yet

    var spreadsheet = new SocialCalc.SpreadsheetControl();
    var savestr = "";
    // Set up the tabs we want
    // Remove Audit
    
    spreadsheet.tabs.splice(spreadsheet.tabnums.audit, 1);
    
    spreadsheet.tabnums = {};
    for (var i=0; i<spreadsheet.tabs.length; i++) {
        spreadsheet.tabnums[spreadsheet.tabs[i].name] = i;
    }
    
    // Add Plain
    
    spreadsheet.tabnums.plain = spreadsheet.tabs.length;
    spreadsheet.tabs.push({
        name: "plain", 
        text: "Plain", 
        html: '<div id="%id.plaintools" style="display:none;"><div style="%tbt.">&nbsp;</div></div>',
        view: "plain",
        onclick: function(s, t) {
            s.views.plain.element.innerHTML = s.CreateSheetHTML();
        },
        onclickFocus: true
    });
    
    spreadsheet.views["plain"] = {
        name: "plain",
        divStyle: "border:1px solid black;overflow:auto;",
        html: 'Plain View'
    };
    
    // Add Graph
    
    spreadsheet.tabnums.graph = spreadsheet.tabs.length;
    spreadsheet.tabs.push({
        name: "graph", 
        text: "Graph", 
        html: '<div id="%id.graphtools" style="display:none;"><div style="%tbt.">&nbsp;</div></div>',
        view: "graph",
        onclick: DoGraph,
        onclickFocus: true
    });
    
    spreadsheet.views["graph"] = {
        name: "graph", 
        divStyle: "overflow:auto;", 
        values: {},
        oncreate: function(s, viewobj) {
            var charttypes = "Horizontal Bar:barh|Vertical Bar:barv|Line:line|Area:area|Scatter:scatter";    
             viewobj.values.panel = {
    //            charttype: {setting: "charttype", type: "PopupList", id: s.idPrefix+"charttype",
    //               initialdata: charttypes},
    //            charttitle: {setting: "chartitle", type: "PopupList", id: s.idPrefix+"charttitle",
    //               initialdata: null}
                };
    
             SocialCalc.SettingsControlInitializePanel(viewobj.values.panel);
        },
        replacements: {
             itemtitle: {regex: /\%itemtitle\./g, replacement: 'style="padding:12px 10px 0px 10px;font-weight:bold;text-align:right;vertical-align:top;font-size:small;"'},
             sectiontitle: {regex: /\%sectiontitle\./g, replacement: 'style="padding:16px 10px 0px 0px;font-weight:bold;vertical-align:top;font-size:small;color:#C00;"'},
             parttitle: {regex: /\%parttitle\./g, replacement: 'style="font-weight:bold;font-size:x-small;padding:0px 0px 3px 0px;"'},
             itembody: {regex: /\%itembody\./g, replacement: 'style="padding:12px 0px 0px 0px;vertical-align:top;font-size:small;"'},
             bodypart: {regex: /\%bodypart\./g, replacement: 'style="padding:0px 10px 0px 0px;font-size:small;vertical-align:top;"'}
        },    
        html:
            '<div id="%id.c-colorchooser" style="display:none;position:absolute;z-index:20;"></div>'+
            '<table id="%id.chartsettingstable" style="display:none;" cellspacing="0" cellpadding="0">'+
            '<table cellspacing="0" cellpadding="0">'+
            '<tr>'+
            ' <td %itemtitle.><br>Chart:</td>'+
            ' <td %itembody.>'+
            '   <table cellspacing="0" cellpadding="0"><tr>'+
            '    <td %bodypart.>'+
            '     <div %parttitle.>Type</div>'+
            '     <select size="1">'+
            '      <option>Horizontal Bar</option>'+
            '      <option>Vertical Bar</option>'+
            '      <option>Line</option>'+
            '      <option>Area</option>'+
            '      <option>Picture</option>'+
            '      <option>Circle</option>'+
            '      <option>Scatter Plot</option>'+
            '     </select>'+
            '    </td>'+
            '    <td %bodypart.>'+
            '     <div %parttitle.>Title</div>'+
            '     <input type="text" size="40" value="">'+
            '    </td>'+
            '   </tr></table>'+
            ' </td>'+
            '</tr>'+
            '<tr>'+
            ' <td %itemtitle.><br>X-Axis:</td>'+
            ' <td %itembody.>'+
            '   <table cellspacing="0" cellpadding="0"><tr>'+
            '    <td %bodypart.>'+
            '     <div %parttitle.>Labels</div>'+
            '     <select size="1"><option>A4</option><option>FIRST</option></select>'+
            '     <input type="button" value="&gt;">'+
            '     <input type="text" size="6" value="">'+
            '    </td>'+
            '    <td %bodypart.>'+
            '     <div %parttitle.>Minimum</div>'+
            '     <select size="1"><option>Default</option><option>Custom</option></select>'+
            '     <input type="text" size="4" value="">'+
            '    </td>'+
            '    <td %bodypart.>'+
            '     <div %parttitle.>Maximum</div>'+
            '     <select size="1"><option>Default</option><option>Custom</option></select>'+
            '     <input type="text" size="4" value="">'+
            '    </td>'+
            '    <td %bodypart.>'+
            '     <div %parttitle.>Name</div>'+
            '     <input type="text" size="20" value="">'+
            '    </td>'+
            '   </tr></table>'+
            ' </td>'+
            '</tr>'+
            '<tr>'+
            ' <td %itemtitle.><br>Y-Axis:</td>'+
            ' <td %itembody.>'+
            '   <table cellspacing="0" cellpadding="0"><tr>'+
            '    <td %bodypart.>'+
            '     <div %parttitle.>Minimum</div>'+
            '     <select size="1"><option>Default</option><option>Custom</option></select>'+
            '     <input type="text" size="4" value="">'+
            '    </td>'+
            '    <td %bodypart.>'+
            '     <div %parttitle.>Maximum</div>'+
            '     <select size="1"><option>Default</option><option>Custom</option></select>'+
            '     <input type="text" size="4" value="">'+
            '    </td>'+
            '    <td %bodypart.>'+
            '     <div %parttitle.>Name</div>'+
            '     <input type="text" size="20" value="">'+
            '    </td>'+
            '   </tr></table>'+
            ' </td>'+
            '</tr>'+
            '<tr>'+
            ' <td %itemtitle.><br>Series 1:</td>'+
            ' <td %itembody.>'+
            '   <table cellspacing="0" cellpadding="0"><tr>'+
            '    <td %bodypart.>'+
            '     <div %parttitle.>Data</div>'+
            '     <select size="1"><option>A4</option><option>FIRST</option></select>'+
            '     <input type="button" value="&gt;">'+
            '     <input type="text" size="6" value="">'+
            '    </td>'+
            '    <td %bodypart.>'+
            '     <div %parttitle.>Color</div>'+
            '     <input type="text" size="6" value="">'+
            '     <span style="border:1px solid black;">&nbsp;&nbsp;&nbsp</span>'+
            '    </td>'+
            '    <td %bodypart.>'+
            '     <div %parttitle.>Symbol</div>'+
            '     <select size="1"><option>None</option><option>Custom</option><option>Star</option><option>Box</option></select>'+
            '    </td>'+
            '    <td %bodypart.>'+
            '     <div %parttitle.>Name</div>'+
            '     <input type="text" size="10" value="">'+
            '    </td>'+
            '   </tr></table>'+
            ' </td>'+
            '</tr>'+
            '<tr>'+
            ' <td %itemtitle.><br>Series 2:</td>'+
            ' <td %itembody.>'+
            '   <table cellspacing="0" cellpadding="0"><tr>'+
            '    <td %bodypart.>'+
            '     <div %parttitle.>Data</div>'+
            '     <select size="1"><option>A4</option><option>FIRST</option><option>[Blank]</option></select>'+
            '     <input type="button" value="&gt;">'+
            '     <input type="text" size="6" value="None">'+
            '    </td>'+
            '    <td %bodypart.>'+
            '     <div %parttitle.>Color</div>'+
            '     <input type="text" size="6" value="">'+
            '     <span style="border:1px solid black;">&nbsp;&nbsp;&nbsp</span>'+
            '    </td>'+
            '    <td %bodypart.>'+
            '     <div %parttitle.>Symbol</div>'+
            '     <select size="1"><option>None</option><option>Custom</option><option>Star</option><option>Box</option></select>'+
            '    </td>'+
            '    <td %bodypart.>'+
            '     <div %parttitle.>Name</div>'+
            '     <input type="text" size="10" value="">'+
            '    </td>'+
            '   </tr></table>'+
            ' </td>'+
            '</tr>'+
            '<tr>'+
            ' <td %itemtitle.><br>Series 3:</td>'+
            ' <td %itembody.>'+
            '   <table cellspacing="0" cellpadding="0"><tr>'+
            '    <td %bodypart.>'+
            '     <div %parttitle.>Data</div>'+
            '     <select size="1"><option>A4</option><option>FIRST</option><option>None</option></select>'+
            '     <input type="button" value="&gt;">'+
            '     <input type="text" size="6" value="None">'+
            '    </td>'+
            '    <td %bodypart.>'+
            '     <div %parttitle.>Color</div>'+
            '     <input type="text" size="6" value="">'+
            '     <span style="border:1px solid black;">&nbsp;&nbsp;&nbsp</span>'+
            '    </td>'+
            '    <td %bodypart.>'+
            '     <div %parttitle.>Symbol</div>'+
            '     <select size="1"><option>None</option><option>Custom</option><option>Star</option><option>Box</option></select>'+
            '    </td>'+
            '    <td %bodypart.>'+
            '     <div %parttitle.>Name</div>'+
            '     <input type="text" size="10" value="">'+
            '    </td>'+
            '   </tr></table>'+
            ' </td>'+
            '</tr>'+
            '<tr>'+
            ' <td %itemtitle.><br>Series 4:</td>'+
            ' <td %itembody.>'+
            '   <table cellspacing="0" cellpadding="0"><tr>'+
            '    <td %bodypart.>'+
            '     <div %parttitle.>Data</div>'+
            '     <select size="1"><option>A4</option><option>FIRST</option><option>None</option></select>'+
            '     <input type="button" value="&gt;">'+
            '     <input type="text" size="6" value="None">'+
            '    </td>'+
            '    <td %bodypart.>'+
            '     <div %parttitle.>Color</div>'+
            '     <input type="text" size="6" value="">'+
            '     <span style="border:1px solid black;">&nbsp;&nbsp;&nbsp</span>'+
            '    </td>'+
            '    <td %bodypart.>'+
            '     <div %parttitle.>Symbol</div>'+
            '     <select size="1"><option>None</option><option>Custom</option><option>Star</option><option>Box</option></select>'+
            '    </td>'+
            '    <td %bodypart.>'+
            '     <div %parttitle.>Name</div>'+
            '     <input type="text" size="10" value="">'+
            '    </td>'+
            '   </tr></table>'+
            ' </td>'+
            '</tr>'+
            '<tr>'+
            ' <td %itemtitle.><br>Series 5:</td>'+
            ' <td %itembody.>'+
            '   <table cellspacing="0" cellpadding="0"><tr>'+
            '    <td %bodypart.>'+
            '     <div %parttitle.>Data</div>'+
            '     <select size="1"><option>A4</option><option>FIRST</option><option>None</option></select>'+
            '     <input type="button" value="&gt;">'+
            '     <input type="text" size="6" value="None">'+
            '    </td>'+
            '    <td %bodypart.>'+
            '     <div %parttitle.>Color</div>'+
            '     <input type="text" size="6" value="">'+
            '     <span style="border:1px solid black;">&nbsp;&nbsp;&nbsp</span>'+
            '    </td>'+
            '    <td %bodypart.>'+
            '     <div %parttitle.>Symbol</div>'+
            '     <select size="1"><option>None</option><option>Custom</option><option>Star</option><option>Box</option></select>'+
            '    </td>'+
            '    <td %bodypart.>'+
            '     <div %parttitle.>Name</div>'+
            '     <input type="text" size="10" value="">'+
            '    </td>'+
            '   </tr></table>'+
            ' </td>'+
            '</tr>'+
            '</table>'
          };
    
       // Add Help
    
       spreadsheet.tabnums.help = spreadsheet.tabs.length;
       spreadsheet.tabs.push({name: "help", text: "Help", html:
          '<div id="%id.helptools" style="display:none;">'+
          ' <div style="%tbt.">&nbsp;</div>'+
          '</div>',
          view: "help",
          onclick: DoHelp,
          onclickFocus: true
          });
    
       spreadsheet.views["help"] = {name: "help",
          divStyle: "border:1px solid black;overflow:auto;",
          html: '<div style="padding:6px;">Help View</div>'
          };
    
       // Initialize the Spreadsheet Control and display it
    
       spreadsheet.InitializeSpreadsheetControl("tableeditor");
       spreadsheet.ExecuteCommand('redisplay', '');
    
       // Done initialization
    
    //
    // * * * FUNCTIONS * * *
    //
    
    //
    // Example of how to get the serialized data
    //
    
    function dosave() {
       savestr = spreadsheet.CreateSpreadsheetSave();
       }
    
    //
    // Example of how to reload the serialized data
    //
    // Don't do this when a command or displaying is being executed. It wipes out the sheet without checking.
    // (If you do this on an initial load, skip the 'redisplay' above.)
    //
    
    function doreload() {
    
       var parts = spreadsheet.DecodeSpreadsheetSave(savestr);
       if (parts) {
          if (parts.sheet) {
             spreadsheet.sheet.ResetSheet();
             spreadsheet.ParseSheetSave(savestr.value.substring(parts.sheet.start, parts.sheet.end));
             }
          if (parts.edit) {
             spreadsheet.editor.LoadEditorSettings(savestr.value.substring(parts.edit.start, parts.edit.end));
             }
          }
       if (spreadsheet.editor.context.sheetobj.attribs.recalc=="off") {
          spreadsheet.ExecuteCommand('redisplay', '');
          }
       else {
          spreadsheet.ExecuteCommand('recalc', '');
          }
       }
    
    // This is just as a demo to show we might have graphing someday. It may be better to have it
    // in a different activity.
    
    function DoGraph(objs, t) {
    
       var maxheight, totalwidth, color, nitems, byrow, maxval, minval, i, cr, cr1, cell, val, extra, eachwidth, str, thisbar;
       var values = [];
       var labels = [];
       var range = objs.editor.range;
    
       var gview = objs.views.graph.element;
    
       if (!range.hasrange) {
          gview.innerHTML = '<div style="padding:30px;font-weight:bold;">Select a range of cells with numeric values to graph.</div>';
          return;
          }
       if (range.left==range.right) { // down
          nitems = range.bottom - range.top + 1;
          byrow = true;
          }
       else {
          nitems = range.right - range.left + 1;
          byrow = false;
          }
    
       str = "";
    
       maxheight = (objs.height-objs.nonviewheight)-50;
       totalwidth = objs.width-30;
       color = "#666";
    
       minval = null;
       maxval = null;
    
       for (i=0; i<nitems; i++) {
          cr = byrow ? SocialCalc.rcColname(range.left)+(i+range.top) : SocialCalc.rcColname(i+range.left)+range.top;
          cr1 = byrow ? SocialCalc.rcColname(range.left-1 || 1)+(i+range.top) : SocialCalc.rcColname(i+range.left)+(range.top-1 || 1);
          cell = objs.sheet.GetAssuredCell(cr);
          if (cell.valuetype.charAt(0) == "n") {
             val = cell.datavalue - 0;
             if (maxval==null || maxval<val) maxval = val;
             if (minval==null || minval>val) minval = val;
             values.push(val);
             cell = objs.sheet.GetAssuredCell(cr1);
             if ((range.right==range.left || range.top==range.bottom) && (cell.valuetype.charAt(0) == "t" || cell.valuetype.charAt(0) == "n")) {
                labels.push(cell.datavalue+"");
                }
             else {
                labels.push(cr);
                }
             }
          }
    
       extra = (maxval-minval)*0.1;
       minval = minval - (extra || 1);
       eachwidth = Math.floor(totalwidth / (values.length || 1))-4 || 1;
    
       str += '<table cellspacing="0" cellpadding="0" width="'+totalwidth+'"><tr>';
    
       for (i=0; i<values.length; i++) {
          thisbar = Math.floor((values[i]-minval)*maxheight/(maxval-minval || 1))+1;
          val = (values[i]+"").substring(0,7);
          str += '<td valign="bottom" style="padding-right:4px;"><table cellspacing="0" cellpadding="0" width="'+eachwidth+'">';
          str += '<tr><td align="center" style="font-size:7pt;">'+val+'</td></tr>';
          str += '<tr><td><div style="height:'+thisbar+'px;background-color:'+color+';width:100%">&nbsp;</div></td></tr>';
          str += '</table></td>';
          }
       str += "</tr><tr>";
       for (i=0; i<values.length; i++) {
          str += '<td align="center" valign="top" style="font-size:8pt;font-weight:bold;padding-top:6px;">'+labels[i]+'</td>';
          }
       str += "</tr></table>";
    
       gview.innerHTML = str;
    
       }
    
    // This is where loading help text might go:
    
    function DoHelp(s, t) {
    
       var hview = s.views.help.element;
    
       var str =
    'HELP TEXT FOLLOWED BY ABOUT TEXT AND LEGAL INFORMATION:<br><br> '+
    'Version 0.7.10<br><br> '+
    '<i>This is an early version of a spreadsheet built on SocialCalc JavaScript code, still in development. '+
    '</i> '+
    '<br><br> '+
    'You can use the arrow keys and mouse to select cells in a manner similar to traditional spreadsheets. '+
    'This includes using the shift key, as well as dragging. '+
    '<br><br> '+
    'The scrollbars should work in a normal manner. '+
    'Because this is a spreadsheet, you can scroll any amount without needing to create new rows or columns. '+
    'Dragging the thumb to the end of a scrollbar attempts to go to the last row or column where there is/was data. '+
    'The mousewheel is also supported. '+
    '<br><br> '+
    'In addition to the scrollbars there are two pane sliders (that start out at the beginning of the scrollbars) '+
    'that let you "lock" the upper rows or columns to facilitate keeping column and row headers visible when scrolling. '+
    '<br><br> '+
    'You can type values in cells. '+
    'An input box will pop up. It may be moved by dragging the top of the box. '+
    'Press Enter, use an arrow key, or click on a cell to finish. '+
    'If you are in a partial formula (e.g., "=1+" or "=SUM(") an arrow key or cell click will '+
    'insert the name of the newly selected cell into the formula, similar to a traditional spreadsheet. '+
    'Cell ranges are separated by typing a ":", or you can use the drag or shift-click range selection methods. '+
    '<br><br> '+
    'The program supports many forms of data, such as numbers, text (preceded by a "\'" if necessary '+
    'to distinguish it from numbers), dates (e.g., "1/2/3"), dollars ("$1,234.50"), time ("3:45"), '+
    'numbers with fractions ("1 1/2"), and "true", "false", and "#N/A". '+
    'A value\'s type determines its displayed format if there is no explicit numeric format set for a cell. '+
    'The program supports a wide variety of formats (including other currencies) through its custom format functionality, '+
    'but this early release only has several that are hardcoded in for you to select from the UI. '+
    '<br><br> '+
    'Use the Esc key to cancel during edits. '+
    'The Del key deletes the values of the selected cell(s). '+
    '<br><br> '+
    'The 109 formula functions that the June 2007 Open Document Format "Open Formula" specification  '+
    'calls the "small group" are available. '+
    '(<b><i>A simple reference to all of the functions is provided below.</i></b>) '+
    'The specification says that: "This group includes approximately 100 functions,  '+
    'and includes the basic functions that are very widely implemented in spreadsheet applications,  '+
    'even in resource-constrained environments."<br><br> '+
    'The definitions of the functions follow common conventions, '+
    'with common syntax similar to many other spreadsheets. '+
    'You can, for example, have a function like IF(B10=B3, "Yes", "No"), where B10 and B3 may contain text values '+
    '(comparisons are not case-sensitive). '+
    '<br><br> '+
    'This release has an early HTML version of an editing interface. '+
    'There is a simple Sugar-like interface for accessing some of the editing API through tabs, buttons, and drop downs. '+
    '<br><br> '+
    'The program maintains an undo stack accessed through the Undo and Redo buttons on the left of the Edit tab toolbar. '+
    'Right now the stack saves up to 100 steps. '+
    '<br><br> '+
    'There is a <b>Format</b> tab for accessing all of the format settings, both for individual cells as well '+
    'as for the sheet-wide defaults that are applied to cells without explicit settings for that attribute. '+
    'You can make changes to any or all of the settings and then press the "Save" button in the toolbar above to apply them. '+
    'While the cell settings are only displayed for the current cell, on "Save" the same changes are applied to all cells '+
    'in the currently highlighted range of cells. '+
    'The Sheet settings let you set the default size of columns. To change the width of an individual column click and '+
    'drag in the column header. '+
    '<br><br> '+
    'The <b>Sort</b> tab lets you select a range of cells (which is remembered) to sort, as well as to set which columns '+
    'are used to determine the order and the direction. '+
    '<br><br> '+
    'There is a <b>Comment</b> tab for accessing the optional comment text for the currently selected cell.'+
    '<br><br> '+
    'The <b>Name</b> tab lets you set named ranges that may be used in formulas.'+
    '<br><br> '+
    'The <b>Graph</b> tab displays a very simple bar graph representation of the cells currently selected as a range '+
    '(either in a single row across or column down). '+
    'If the range is a single row or column, and if the row above (or column to the left) has values, those values are used as labels. '+
    'Otherwise the cell coordinates are used (e.g., B5). '+
    'This is a very early, minimal implementation. '+
    '<br><br> '+
    'The <b>Plain</b> tab shows the sheet rendered without the grid or editing controls. '+
    '<br><br> '+
    'The <b>Clipboard</b> tab lets you view the SocialCalc clipboard in tab-delimited format, and optionally reload it with new data. '+
    'Tab-delimited format is what a browser and Excel put on the clipboard when you select and then copy cells in a table. '+
    'The Clipboard tab also supports CSV format and the SocialCalc Save format (useful for copying from one sheet to another). '+
    'Reloading from the SocialCalc Save format must be in correct format -- errors can cause SocialCalc to behave badly. '+
    'Pressing Ctrl-V when on the Edit tab and not editing a cell assumes that Tab-delimited data is on the regular '+
    'clipboard, loads it into the SocialCalc clipboard, and then "pastes" it starting at the current cell. '+
    'This is an easy way to copy data from a web page into a spreadsheet. '+
    '<br><br> '+
    'Right now this code is mainly being developed to run under control of a native Python '+
    'application running on the OLPC XO. '+
    'This version, though, can also be run directly in a browser. '+
    '<br><br> '+
    'When the program encounters an error, it may display a message at the bottom of the screen. '+
    'You can click on the message to erase it. '+
    '<br><br> '+
    'Comments can be sent to "socialcalc" at "softwaregarden.com". '+
    '<br><br> '+
    '<hr> '+
    '<b>FUNCTION HELP</b> '+
    '<br><br> '+
    'The following functions are currently supported in formulas (case is ignored in function names): '+
    '<style> '+
    '.helplist dt {font-weight:bold;} '+
    '.helplist dd {padding-bottom:6pt;} '+
    '</style> '+
    '<div style="padding:6pt 0px 0px 1em;" class="helplist"> '+
    '<dl> '+
    '<dt>ABS(value)<dd>Absolute value function. '+
    '<dt>ACOS(value)<dd>Trigonometric arccosine function. '+
    '<dt>AND(value1, value2, ...)<dd>True if all arguments are true. '+
    '<dt>ASIN(value)<dd>Trigonometric arcsine function. '+
    '<dt>ATAN(value)<dd>Trigonometric arctan function. '+
    '<dt>ATAN2(valueX, valueY)<dd>Trigonometric arc tangent function (result is in radians). '+
    '<dt>AVERAGE(value, value, ...)<dd>Averages the values. '+
    '<dt>CHOOSE(index, value1, value2, ...)<dd>Returns the value specified by the index. The values may be ranges of cells. '+
    '<dt>COLUMNS(range)<dd>Returns the number of columns in the range. '+
    '<dt>COS(value)<dd>Trigonometric cosine function (value is in radians). '+
    '<dt>COUNT(value, value, ...)<dd>Counts the number of numeric values, not blank, text, or error. '+
    '<dt>COUNTA(value, value, ...)<dd>Counts the number of non-blank values. '+
    '<dt>COUNTBLANK(value, value, ...)<dd>Counts the number of blank values. (Note: "" is not blank.) '+
    '<dt>COUNTIF(range, criteria)<dd>Counts the number of number of cells in the range that meet the criteria. '+
    'The criteria may be a value ("x", 15, 1+3) or a test (>25). '+
    '<dt>DATE(year, month, day)<dd>Returns the appropriate date value given numbers for year, month, and day. '+
    'For example: DATE(2006,2,1) for February 1, 2006. '+
    'Note: In this program, day "1" is December 31, 1899 and the year 1900 is not a leap year. '+
    'Some programs use January 1, 1900, as day "1" and treat 1900 as a leap year. '+
    'In both cases, though, dates on or after March 1, 1900, are the same. '+
    '<dt>DAVERAGE(databaserange, fieldname, criteriarange)<dd>Averages the values in the specified field in records that meet the criteria. '+
    '<dt>DAY(value)<dd>Returns the day of month for a date value. '+
    '<dt>DCOUNT(databaserange, fieldname, criteriarange)<dd>Counts the number of numeric values, not blank, text, or error, in the specified field in records that meet the criteria. '+
    '<dt>DCOUNTA(databaserange, fieldname, criteriarange)<dd>Counts the number of non-blank values in the specified field in records that meet the criteria. '+
    '<dt>DDB(cost, salvage, lifetime, period [, factor])<dd> '+
    'Returns the amount of depreciation at the given period of time '+
    '(the default factor is 2 for double-declining balance).   '+
    '<dt>DEGREES(value)<dd>Converts value in radians in to degrees. '+
    '<dt>DGET(databaserange, fieldname, criteriarange)<dd>Returns the value of the specified field in the single record that meets the criteria. '+
    '<dt>DMAX(databaserange, fieldname, criteriarange)<dd>Returns the maximum of the numeric values in the specified field in records that meet the criteria. '+
    '<dt>DMIN(databaserange, fieldname, criteriarange)<dd>Returns the maximum of the numeric values in the specified field in records that meet the criteria. '+
    '<dt>DPRODUCT(databaserange, fieldname, criteriarange)<dd>Returns the result of multiplying the numeric values in the specified field in records that meet the criteria. '+
    '<dt>DSTDEV(databaserange, fieldname, criteriarange)<dd>Returns the sample standard deviation of the numeric values in the specified field in records that meet the criteria. '+
    '<dt>DSTDEVP(databaserange, fieldname, criteriarange)<dd>Returns the standard deviation of the numeric values in the specified field in records that meet the criteria. '+
    '<dt>DSUM(databaserange, fieldname, criteriarange)<dd>Returns the sum of the numeric values in the specified field in records that meet the criteria. '+
    '<dt>DVAR(databaserange, fieldname, criteriarange)<dd>Returns the sample variance of the numeric values in the specified field in records that meet the criteria. '+
    '<dt>DVARP(databaserange, fieldname, criteriarange)<dd>Returns the variance of the numeric values in the specified field in records that meet the criteria. '+
    '<dt>EVEN(value)<dd>Rounds the value up in magnitude to the nearest even integer. '+
    '<dt>EXACT(value1, value2)<dd>Returns "true" if the values are exactly the same, including case, type, etc. '+
    '<dt>EXP(value)<dd>Returns e raised to the value power. '+
    '<dt>FACT(value)<dd>Returns factorial of the value. '+
    '<dt>FALSE( )<dd>Returns the logical value "false". '+
    '<dt>FIND(string1, string2 [, start])<dd>Returns the starting position within string2 of the first '+
    'occurrence of string1 at or after "start". If start is omitted, 1 is assumed. '+
    '<dt>FV(rate, n, payment, [pv, [paytype]])<dd>Returns the future value of repeated payments of money '+
    'invested at the given rate for the specified number of periods, '+
    'with optional present value (default 0) and payment type '+
    '(default 0 = at end of period, 1 = beginning of period). '+
    '<dt>HLOOKUP(value, range, row, [rangelookup])<dd>Look for the matching value for the given value in the '+
    'range and return the corresponding value in the cell specified by the row offset. '+
    'If rangelookup is 1 (the default) and not 0, match if within numeric brackets (match&lt;=value) instead of exact match. '+
    '<dt>HOUR(value)<dd>Returns the hour portion of a time or date/time value. '+
    '<dt>IF(logical-expression, true-value, false-value)<dd>Results in true-value if logical-expression is TRUE or non-zero, '+
    'otherwise results in false-value. '+
    '<dt>INDEX(range, rownum, colnum)<dd>Returns a cell or range reference for the specified row and column in the range. '+
    'If range is 1-dimensional, then only one of rownum or colnum are needed. '+
    'If range is 2-dimensional and rownum or colnum are zero, a reference to the range of just the specified column or row is returned. '+
    'You can use the returned reference value in a range, e.g., sum(A1:INDEX(A2:A10,4)). '+
    '<dt>INT(value)<dd>Returns the value rounded down to the nearest integer (towards -infinity). '+
    '<dt>IRR(range, [guess])<dd>Returns the interest rate at which the cash flows in the range '+
    'have a net present value of zero. Uses an iterative process that will return '+
    '#NUM! error if it does not converge. '+
    'There may be more than one possible solution. '+
    'Providing the optional guess value may help in certain situations '+
    'where it does not converge or finds an inappropriate solution (the default guess is 10%). '+
    '<dt>ISBLANK(value)<dd>Returns "true" if the value is a reference to a blank cell. '+
    '<dt>ISERR(value)<dd>Returns "true" if the value is of type "Error" but not "NA". '+
    '<dt>ISERROR(value)<dd>Returns "true" if the value is of type "Error". '+
    '<dt>ISLOGICAL(value)<dd>Returns "true" if the value is of type "Logical" (true/false). '+
    '<dt>ISNA(value)<dd>Returns "true" if the value is the error type "NA". '+
    '<dt>ISNONTEXT(value)<dd>Returns "true" if the value is not of type "Text". '+
    '<dt>ISNUMBER(value)<dd>Returns "true" if the value is of type "Number" (including logical values). '+
    '<dt>ISTEXT(value)<dd>Returns "true" if the value is of type "Text". '+
    '<dt>LEFT(text, count)<dd>Returns the specified number of characters from the text value. '+
    'If count is omitted, 1 is assumed. '+
    '<dt>LEN(text)<dd>Returns the number of characters in the text value. '+
    '<dt>LN(value)<dd>Returns the natural logarithm of the value. '+
    '<dt>LOG(value, base)<dd>Returns the logarithm of the value using the specified base. '+
    '<dt>LOG10(value)<dd>Returns the base 10 logarithm of the value. '+
    '<dt>LOWER(text)<dd>Returns the text value with all uppercase characters converted to lowercase. '+
    '<dt>MATCH(value, range, [rangelookup])<dd>Look for the matching value for the given value in the '+
    'range and return position (the first is 1) in that range. '+
    'If rangelookup is 1 (the default) and not 0, match if within numeric brackets (match&lt;=value) instead of exact match. '+
    'If rangelookup is -1, act like 1 but the bracket is match&gt;=value. '+
    '<dt>MAX(value, value, ...)<dd>Returns the maximum of the numeric values. '+
    '<dt>MID(text, start, length)<dd>Returns the specified number of characters from the text value '+
    'starting from the specified position. '+
    '<dt>MIN(value1, value2, ...)<dd>Returns the minimum of the numeric values. '+
    '<dt>MINUTE(value)<dd>Returns the minute portion of a time or date/time value. '+
    '<dt>MOD(value1, value2)<dd>Returns the remainder of the first value divided by the second. '+
    '<dt>MONTH(value)<dd>Returns the month part of a date value. '+
    '<dt>N(value)<dd>Returns the value if it is a numeric value otherwise an error. '+
    '<dt>NA( )<dd>Returns the #N/A error value which propagates through most operations. '+
    '<dt>NOT(value)<dd>Returns FALSE if value is true, and TRUE if it is false. '+
    '<dt>NOW( )<dd>Returns the current date/time. '+
    '<dt>NPER(rate, payment, pv, [fv, [paytype]])<dd>Returns the number of periods at which '+
    'payments invested each period at the given rate with optional future value (default 0) '+
    'and payment type (default 0 = at end of period, 1 = beginning of period) '+
    'has the given present value. '+
    '<dt>NPV(rate, value1, value2, ...)<dd>Returns the net present value of cash flows '+
    '(which may be individual values and/or ranges) at the given rate. '+
    'The flows are positive if income, negative if paid out, and are assumed at the end of '+
    'each period. '+
    '<dt>ODD(value)<dd>Rounds the value up in magnitude to the nearest odd integer. '+
    '<dt>OR(value1, value2,...)<dd>True if any argument is true '+
    '<dt>PI( )<dd>The value 3.1415926... '+
    '<dt>PMT(rate, n, pv, [fv, [paytype]])<dd>Returns the amount of each payment that must be '+
    'invested at the given rate for the specified number of periods '+
    'to have the specified present value, with optional future value (default 0) '+
    'and payment type (default 0 = at end of period, 1 = beginning of period). '+
    '<dt>POWER(value1, value2)<dd>Returns the first value raised to the second value power. '+
    '<dt>PRODUCT(value1, value2, ...)<dd>Returns the result of multiplying the numeric values. '+
    '<dt>PROPER(value)<dd>Returns the text value with the first letter of each word '+
    'converted to uppercase and the others to lowercase. '+
    '<dt>PV(rate, n, payment, [fv, [paytype]])<dd>Returns the present value of '+
    'the given number of payments each invested at the given rate, '+
    'with optional future value (default 0) '+
    'and payment type (default 0 = at end of period, 1 = beginning of period). '+
    '<dt>RADIANS(value)<dd>Converts value in degrees into radians. '+
    '<dt>RATE(n, payment, pv, [fv, [paytype, [guess]]])<dd>Returns the rate at which '+
    'the given number of payments each invested at the given rate has the '+
    'specified present value, with optional future value (default 0) '+
    'and payment type (default 0 = at end of period, 1 = beginning of period). '+
    'Uses an iterative process that will return #NUM! error if it does not converge. '+
    'There may be more than one possible solution. '+
    'Providing the optional guess value may help in certain situations '+
    'where it does not converge or finds an inappropriate solution (the default guess is 10%). '+
    '<dt>REPLACE(text1, start, length, text2)<dd>Returns text1 with the specified number of characters '+
    'starting from the specified position replaced by text2. '+
    '<dt>REPT(text, count)<dd>Returns the text repeated the specified number of times. '+
    '<dt>RIGHT(text, count)<dd>Returns the specified number of characters from the text value '+
    'starting from the end. '+
    'If count is omitted, 1 is assumed. '+
    '<dt>ROUND(value, [precision])<dd>Rounds the value to the specified number of decimal places. '+
    'If precision is negative, then round to powers of 10. '+
    'The default precision is 0 (round to integer). '+
    '<dt>ROWS(range)<dd>Returns the number of rows in the range. '+
    '<dt>SECOND(value)<dd>Returns the second portion of a time or date/time value (truncated to an integer). '+
    '<dt>SIN(value)<dd>Trigonometric sine function (value is in radians) '+
    '<dt>SLN(cost, salvage, lifetime, period)<dd> '+
    'Returns the amount of depreciation at each period of time using the straight-line method. '+
    '<dt>SQRT(value)<dd>Square root of the value '+
    '<dt>STDEV(value, value, ...)<dd>Returns the sample standard deviation of the numeric values. '+
    '<dt>STDEVP(value, value, ...)<dd>Returns the standard deviation of the numeric values. '+
    '<dt>SUBSTITUTE(text1, oldtext, newtext [, occurrence])<dd>Returns text1 with the all occurrences '+
    'of oldtext replaced by newtext. If "occurrence" is present, then only that occurrence is replaced. '+
    '<dt>SUM(value, value, ...)<dd>Adds the numeric values. The values to the sum function may be ranges in the form similar to A1:B5. '+
    '<dt>SUMIF(range1, criteria [, range2])<dd>Sums the numeric values of cells in the range that meet the criteria. '+
    'The criteria may be a value ("x", 15, 1+3) or a test (>25). '+
    'If range2 is present, then range1 is tested and the corresponding range2 value is summed. '+
    '<dt>SYD(cost, salvage, lifetime, period)<dd>Depreciation by Sum of Year\'s Digits method. '+
    '<dt>T(value)<dd>Returns the text value or else a null string. '+
    '<dt>TAN(value)<dd>Trigonometric tangent function (value is in radians) '+
    '<dt>TIME(hour, minute, second)<dd>Returns the time value given the specified '+
    'hour, minute, and second. '+
    '<dt>TODAY( )<dd>Returns the current date (an integer). '+
    'Note: In this program, day "1" is December 31, 1899 and the year 1900 is not a leap year. '+
    'Some programs use January 1, 1900, as day "1" and treat 1900 as a leap year. '+
    'In both cases, though, dates on or after March 1, 1900, are the same. '+
    '<dt>TRIM(text)<dd>Returns the text value with leading, trailing, and repeated spaces removed. '+
    '<dt>TRUE( )<dd>Returns the logical value "true". '+
    '<dt>TRUNC(value, precision)<dd>Truncates the value to the specified number of decimal places. '+
    'If precision is negative, truncate to powers of 10. '+
    '<dt>UPPER(text)<dd>Returns the text value with all lowercase characters converted to uppercase. '+
    '<dt>VALUE(value)<dd>Converts the specified text value into a numeric value. '+
    'Various forms that look like numbers (including digits followed by %, forms that look like '+
    'dates, etc.) are handled. '+
    'This may not handle all of the forms accepted by other spreadsheets and may be '+
    'locale dependent. '+
    '<dt>VAR(value, value, ...)<dd>Returns the sample variance of the numeric values. '+
    '<dt>VARP(value, value, ...)<dd>Returns the variance of the numeric values. '+
    '<dt>VLOOKUP(value, range, col, [rangelookup])<dd>Look for the matching value for the given value in the '+
    'range and return the corresponding value in the cell specified by the column offset. '+
    'If rangelookup is 1 (the default) and not 0, match if within numeric brackets (match&lt;=value) instead of exact match. '+
    '<dt>WEEKDAY(date, [type])<dd>Returns the day of week specified by the date value. '+
    'If type is 1 (the default), Sunday is day and Saturday is day 7. '+
    'If type is 2, Monday is day 1 and Sunday is day 7. '+
    'If type is 3, Monday is day 0 and Sunday is day 6. '+
    '<dt>YEAR(date)<dd>Returns the year part of a date value. '+
    '</dl> '+
    '<hr>ABOUT TEXT:<br><br> '+
    '<i>This is an early version of the SocialCalc Activity for the OLPC XO computer. '+
    'It uses the SocialCalc JavaScript libraries, still in development, as well as (on the XO) '+
    'the beginning of a general purpose Python program for running JavaScript activities in '+
    'the Sugar environment.<br><br> '+
    'For more information, see the Software Garden OLPC Home Page (www.peapodcast.com/sgi/olpc).</i> '+
    '<br><br> '+
    '(c) Copyright 2008 Socialtext, Inc.<br> '+
    'All Rights Reserved. '+
    '<br><br> '+
    'This product consists of components licensed under different licenses. '+
    'Some are licensed under the Common Public Attribution License (CPAL) and '+
    'others under the Artistic License 2.0. '+
    'Check the contents of each file for a statement of the license for that file. '+
    'Files without license information (e.g., image files) are licensed under the Artistic License 2.0. '+
    'The source code comes with a LEGAL.txt file and a LICENSE.txt file. '+
    'For more information, see the web page listed above. '+
    '<br><br> '+
    'The software is distributed on an "AS IS" basis, WITHOUT WARRANTY OF ANY  '+
    'KIND, either express or implied. See the License for the specific language governing rights and  '+
    'limitations under the License. '+
    '<br><br> '+
    'The OLPC part of this project has been coordinated by Manusheel Gupta of OLPC  '+
    'with guidance from Walter Bender and others of OLPC. '+
    '<br><br> '+
    'The Python code for the OLPC XO-1 was initially coded by Luke Closs of Socialtext, Inc. '+
    ' and/or by K.S. Preeti (depending upon the version). '+
    '<br><br> '+
    'The JavaScript SocialCalc code was initially coded by Dan Bricklin of Software Garden, Inc., for Socialtext, Inc.<br> '+
    'Based in part on the SocialCalc 1.1.0 code written in Perl.<br> '+
    'The SocialCalc 1.1.0 code was:<br> '+
    '<blockquote> '+
    '    Portions (c) Copyright 2005, 2006, 2007 Software Garden, Inc.<br> '+
    '    All Rights Reserved.<br> '+
    '    Portions (c) Copyright 2007 Socialtext, Inc.<br> '+
    '    All Rights Reserved.<br> '+
    '</blockquote> '+
    'The Perl SocialCalc started as modifications to the wikiCalc(R) program, version 1.0.<br> '+
    'wikiCalc 1.0 was written by Software Garden, Inc.<br> '+
    '<br><br> '+
    '<span class="smaller">wikiCalc, Garden, and Software Garden are registered trademarks of Software Garden, Inc.<br> '+
    'Socialtext, SocialCalc, and the Socialtext logo and Dreamcatcher are trademarks of Socialtext, Inc.<br> '+
    'Dan Bricklin\'s is a registered trademark of Daniel Bricklin.</span>';
    
    hview.firstChild.innerHTML = str;
    }
});