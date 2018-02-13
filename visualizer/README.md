Visualizer
==========

## Usage Instructions

Visualizer takes two `GET` parameters (namely `iun` and `version`) on `visualize` route in order to visualize the compressed Notation3 decisions of Diavgeia. By default the visualizer listens on port 3333.

For demonstration reasons, a `const DECISIONS_DIRECTORY` is set in `index.js (line:12)` to point to the [rdf samples folder](https://github.com/themisb/diavgeiaRedefined/tree/master/rdf/samples). You can pass a pair of `decisionFolder`, `iun` GET parameters in order to see the visualization of those samples. For instance, a call to `localhost:3333/visualize?decisionFolder=Appointment&iun=ΨΟΗΩ46ΨΖΣ4-Ι56`, will result to the visualization of this `.n3` [appointment decision](https://github.com/themisb/gsoc17-diavgeia/blob/master/rdf/samples/Appointment/%CE%A8%CE%9F%CE%97%CE%A946%CE%A8%CE%96%CE%A34-%CE%9956.n3), as follows:

![Visualization of an appointment](http://image.ibb.co/g1Y0U5/visualization.png)