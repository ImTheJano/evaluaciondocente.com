-- promedio por cada pregunta, de un profesor
SELECT
	ep.numP,
	sum(ep.evaluacion),
	count(ep.evaluacion),
	(sum(ep.evaluacion)/count(ep.evaluacion))
FROM
	encuestapregunta ep,
	encuestaconteo e,
	profesor p
WHERE
	p.claveProf='59' and
	e.claveProf=p.claveProf and
	ep.idE=e.idE
GROUP BY
	ep.numP;
	
-- promedio general por cada profesor
SELECT
	p.claveProf,
	sum(ep.evaluacion),
	count(ep.evaluacion),
	(sum(ep.evaluacion)/count(ep.evaluacion))
FROM
	encuestapregunta ep,
	encuestaconteo e,
	profesor p
WHERE
	e.claveProf=p.claveProf and
	ep.idE=e.idE
GROUP BY
	p.claveProf;
