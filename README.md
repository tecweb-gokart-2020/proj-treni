# Progetto Tecweb 2020
Realizzazione di un sito "vetrina" per
[trenene](http://www.trenene.it). Requisiti nel file
`REQUISITI.md`
## Installazione
Per installare il progetto in una cartella esposta con un qualche tipo di server basta far partire lo script all'interno
del progetto indicando la path della cartella esposta (meglio che questa differisca dalla cartella di progetto) 
```sh 
	./install [PATH della cartella public_html]
```
La path alla cartella `public_html` può essere anche relativa, quello
che fa alla fine è impostare dei link nella cartella `public_html` che 
rimandano ai file necessari nella cartella del progetto.
## Test
### Docker
Il metodo principale è utilizzare [Docker](https://www.docker.com/) si mette in piedi un server locale che espone la vista del progetto, **importante**:
**i cambiamenti non saranno live**. Se cambiate dei file non sarà sufficiente ricaricare il browser per vedere i 
cambiamenti, bensì sarà necessario fermare il container di docker, ricostruirlo e farlo ripartire. I dati non andranno
comunque persi dato che lo stato è persistito grazie ad un altro container che mette in piedi un server di mysql.
### Come usare docker
Il processo è semplice: Crea il continer &#8594; fallo partire &#8594; testa il sito &#8594; ferma il container.
Se necessario distruggilo (l'unica differenza tra fermarlo e distruggerlo è che distruggendolo i dati vanno persi e per 
farlo partire di nuovo bisogna costruirlo di nuovo).
### Make
#### Costruire il container
```shell
make install
```
questo comando particolare lo fa anche partire

#### far partire il container
```shell
make start
```

#### fermare il container
```shell
make stop
```

#### distruggere il container
```shell
# rimuove solo il container
make remove
# rimuove il container e tutti i volumi (quindi i dati) associati
make purge
```

#### fermare il container, distruggerlo e ricrearlo facendolo ripartire
Essendo un caso d'uso molto comune
```shell
make rebuild
```

### docker-compose
#### Costruire il container
```shell
docker-compose up
```
questo comando particolare lo fa anche partire

#### far partire il container
```shell
docker-compose start
```

#### fermare il container
```shell
docker-comopose stop
```

#### distruggere il container
```shell
docker-compose down
```

#### fermare il container, distruggerlo e ricrearlo facendolo ripartire
Essendo un caso d'uso molto comune
```shell
docker-compose down && docker-compose up
```

# Importante!!
per fare test è necessario impostare username e password del proprio
database in `src/includes/class/db.class.php`, altrimenti le
connessioni falliscono.
## Per docker invece
Adesso le credenziali sono proprio quelle di docker
