SET @position:=0;
update pension_classe
SET code = CONCAT(code, @position:=@position+1)
WHERE true