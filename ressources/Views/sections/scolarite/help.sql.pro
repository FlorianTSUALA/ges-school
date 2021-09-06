SET @position:=0;
UPDATE pension_classe
SET code = CONCAT(code, @position:=@position+1)
WHERE true

# BETWEEN [7 - 12]
FLOOR(7 + (RAND() * 5))

UPDATE pension_classe
SET montant = FLOOR( ( (RAND() *9) * 1000) + (RAND() * 5000))
WHERE true

