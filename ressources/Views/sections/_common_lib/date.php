<script>

//Add days to a new instance of JavaScript Date
function addDays(date, days) {
  const copy = new Date(Number(date))
  copy.setDate(date.getDate() + days)
  return copy
}

const date = new Date();
const newDate = addDays(date, 10);

//Update a JavaScript Date with added days
const date = new Date();
date.setDate(date.getDate() + 10);

//This actually works as expected, eg. the month rolls over.
const d = new Date('2019-04-14');

const monthRollsOver = addDays(myDate, 31);
console.log(monthsRollOver)
// 2019-05-15

</script>