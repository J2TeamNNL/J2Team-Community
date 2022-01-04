// ex: =sumByLastColumn(A1;{11;12})
function sumByLastColumn(name = 'test', arrayRange = []) {
  const activeSheet = SpreadsheetApp.getActiveSpreadsheet();
  const currentSheetName = activeSheet.getActiveSheet().getName();
  let sum = 0;
  let textFinder, row, column, thisSheetName, checkExists;
  const checkHaveRange = arrayRange.length > 0;

  activeSheet.getSheets().map(function(x) {
      thisSheetName = x.getName();
      if(checkHaveRange){
        checkExists = false;
        arrayRange.map((el, key) => {
          if(thisSheetName.search(el) != -1){
            checkExists = true;
            delete arrayRange[key];
          }
        })
        if(!checkExists){
          return false;
        }
      }
      if(thisSheetName !== currentSheetName){
        textFinder = x.createTextFinder(name).findNext();
        if(textFinder){
          row = textFinder.getRow();
          column = x.getLastColumn();
          sum += x.getRange(row,column).getValue();
        }
      }
  });

  return sum;
}
