# resistors
resistor dividers calculations with R- codes

this is my first attempt at PHP. I was helped by BARD to find the syntax needed. I have not got the time to make it pretty.

example input 10 12 0.6 0.6 E12 10 will result in this output:

vmin 10 vmax 12 vrefmax 0.6 vrefmin 0.6 series 12 factor 10
voltage divider
  TOP       LOSS     BOT E24BOT E24PAR
   100(101)    1.4W   5.3   5.6(5R6)   100(101)   114mA
   120(121)    1.2W   6.3   6.8(6R8)   100(101)  95.0mA
   150(151)   960mW   7.9   8.2(8R2)             76.0mA
   180(181)   800mW   9.5    10(100)   180(181)  63.3mA
   220(221)   655mW    12    12(120)             51.8mA
   270(271)   533mW    14    15(150)   270(271)  42.2mA
   330(331)   436mW    17    18(180)             34.5mA
   390(391)   369mW    21    22(220)   330(331)  29.2mA
   470(471)   306mW    25    27(270)   330(331)  24.3mA
   560(561)   257mW    29    33(330)   270(271)  20.4mA
   680(681)   212mW    36    39(390)   470(471)  16.8mA
   820(821)   176mW    43    47(470)   560(561)  13.9mA
potentiometer divider
  TOP   E24TOP     E24PAR       POT   BOT   E24BOT   E24PAR
  9.4k   10k(103)  180k(184)|   100   500   560(561)  4.7k(472)| I:   1.2mA
 18.8k   22k(223)  150k(154)|   200  1.0k  1.0k(102)           | I:   600uA
 28.2k   33k(333)  220k(224)|   300  1.5k  1.5k(152)           | I:   400uA
 47.0k   47k(473)           |   500  2.5k  2.7k(272)   33k(333)| I:   240uA
 94.0k  100k(104)  1.8M(185)|  1.0k  5.0k  5.6k(562)   47k(473)| I:   120uA
  188k  220k(224)  1.5M(155)|  2.0k 10.0k   10k(103)           | I:   60uA
  282k  330k(334)  2.2M(225)|  3.0k 15.0k   15k(153)           | I:   40uA
  470k  470k(474)           |  5.0k 25.0k   27k(273)  330k(334)| I:   24uA
  940k  1.0M(105)   18M(186)|   10k 50.0k   56k(563)  470k(474)| I:   12uA
  1.9M  2.2M(225)   15M(156)|   20k  100k  100k(104)           | I:   6uA
  2.8M  3.3M(335)   22M(226)|   30k  150k  150k(154)           | I:   4uA
  4.7M  4.7M(475)           |   50k  250k  270k(274)  3.3M(335)| I:   2uA
