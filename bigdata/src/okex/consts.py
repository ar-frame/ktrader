

# http header
API_URL = 'https://www.okex.me'
CONTENT_TYPE = 'Content-Type'
OK_ACCESS_KEY = 'OK-ACCESS-KEY'
OK_ACCESS_SIGN = 'OK-ACCESS-SIGN'
OK_ACCESS_TIMESTAMP = 'OK-ACCESS-TIMESTAMP'
OK_ACCESS_PASSPHRASE = 'OK-ACCESS-PASSPHRASE'


ACEEPT = 'Accept'
COOKIE = 'Cookie'
LOCALE = 'Locale='

APPLICATION_JSON = 'application/json'

GET = "GET"
POST = "POST"
DELETE = "DELETE"

SERVER_TIMESTAMP_URL = '/api/general/v3/time'

# account

CURRENCIES_INFO = '/api/account/v3/currencies'
WALLET_INFO = '/api/account/v3/wallet'
CURRENCY_INFO = '/api/account/v3/wallet/'
COIN_TRANSFER = '/api/account/v3/transfer'
COIN_WITHDRAW = '/api/account/v3/withdrawal'
COIN_FEE = '/api/account/v3/withdrawal/fee'
COINS_WITHDRAW_RECORD = '/api/account/v3/withdrawal/history'
COIN_WITHDRAW_RECORD = '/api/account/v3/withdrawal/history/'
LEDGER_RECORD = '/api/account/v3/ledger'
TOP_UP_ADDRESS = '/api/account/v3/deposit/address'
COIN_TOP_UP_RECORDS = '/api/account/v3/deposit/history'
COIN_TOP_UP_RECORD = '/api/account/v3/deposit/history/'

# spot
SPOT_ACCOUNT_INFO = '/api/spot/v3/accounts'
SPOT_COIN_ACCOUNT_INFO = '/api/spot/v3/accounts/'
SPOT_LEDGER_RECORD = '/api/spot/v3/accounts/'
SPOT_ORDER = '/api/spot/v3/orders'
SPOT_ORDERS = '/api/spot/v3/batch_orders'
SPOT_REVOKE_ORDER = '/api/spot/v3/cancel_orders/'
SPOT_REVOKE_ORDERS = '/api/spot/v3/cancel_batch_orders/'
SPOT_ORDERS_LIST = '/api/spot/v3/orders'
SPOT_ORDERS_PENDING = '/api/spot/v3/orders_pending'
SPOT_ORDER_INFO = '/api/spot/v3/orders/'
SPOT_FILLS = '/api/spot/v3/fills'
SPOT_COIN_INFO = '/api/spot/v3/instruments'
SPOT_DEPTH = '/api/spot/v3/instruments/'
SPOT_TICKER = '/api/spot/v3/instruments/ticker'
SPOT_SPECIFIC_TICKER = '/api/spot/v3/instruments/'
SPOT_DEAL = '/api/spot/v3/instruments/'
SPOT_KLINE = '/api/spot/v3/instruments/'

# lever
LEVER_ACCOUNT = '/api/margin/v3/accounts'
LEVER_COIN_ACCOUNT = '/api/margin/v3/accounts/'
LEVER_LEDGER_RECORD = '/api/margin/v3/accounts/'
LEVER_CONFIG = '/api/margin/v3/accounts/availability'
LEVER_SPECIFIC_CONFIG = '/api/margin/v3/accounts/'
LEVER_BORROW_RECORD = '/api/margin/v3/accounts/'
LEVER_SPECIFIC_BORROW_RECORD = '/api/margin/v3/accounts/'
LEVER_BORROW_COIN = '/api/margin/v3/accounts/borrow'
LEVER_REPAYMENT_COIN = '/api/margin/v3/accounts/repayment'
LEVER_ORDER = '/api/margin/v3/orders'
LEVER_ORDERS = '/api/margin/v3/batch_orders'
LEVER_REVOKE_ORDER = '/api/margin/v3/cancel_orders/'
LEVER_REVOKE_ORDERS = '/api/margin/v3/cancel_batch_orders'
LEVER_ORDER_LIST = '/api/margin/v3/orders'
LEVEL_ORDERS_PENDING = '/api/margin/v3/orders_pending'
LEVER_ORDER_INFO = '/api/margin/v3/orders/'
LEVER_FILLS = '/api/margin/v3/fills'
FF = '/api/futures/v3/orders'

# future
FUTURE_POSITION = '/api/futures/v3/position'
FUTURE_SPECIFIC_POSITION = '/api/futures/v3/'
FUTURE_ACCOUNTS = '/api/futures/v3/accounts'
FUTURE_COIN_ACCOUNT = '/api/futures/v3/accounts/'
FUTURE_GET_LEVERAGE = '/api/futures/v3/accounts/'
FUTURE_SET_LEVERAGE = '/api/futures/v3/accounts/'
FUTURE_LEDGER = '/api/futures/v3/accounts/'
FUTURE_DELETE_POSITION = '/api/futures/v3/close_all_orders'
FUTURE_ORDER = '/api/futures/v3/order'
FUTURE_ORDERS = '/api/futures/v3/orders'
FUTURE_REVOKE_ORDER = '/api/futures/v3/cancel_order/'
FUTURE_REVOKE_ORDERS = '/api/futures/v3/cancel_batch_orders/'
FUTURE_ORDERS_LIST = '/api/futures/v3/orders'
FUTURE_ORDER_INFO = '/api/futures/v3/orders/'
FUTURE_FILLS = '/api/futures/v3/fills'
FUTURE_PRODUCTS_INFO = '/api/futures/v3/instruments'
FUTURE_DEPTH = '/api/futures/v3/instruments/'
FUTURE_TICKER = '/api/futures/v3/instruments/ticker'
FUTURE_SPECIFIC_TICKER = '/api/futures/v3/instruments/'
FUTURE_TRADES = '/api/futures/v3/instruments/'
FUTURE_KLINE = '/api/futures/v3/instruments/'
FUTURE_INDEX = '/api/futures/v3/instruments/'
FUTURE_RATE = '/api/futures/v3/rate'
FUTURE_ESTIMAT_PRICE = '/api/futures/v3/instruments/'
FUTURE_HOLDS = '/api/futures/v3/instruments/'
FUTURE_LIMIT = '/api/futures/v3/instruments/'
FUTURE_LIQUIDATION = '/api/futures/v3/instruments/'
FUTURE_MARK = '/api/futures/v3/instruments/'
HOLD_AMOUNT = '/api/futures/v3/accounts/'
#CURRENCY_LIST = '/api/futures/v3/instruments/currencies/'

# ETT
ETT_ACCOUNTS = '/api/ett/v3/accounts'
ETT_ACCOUNT = '/api/ett/v3/accounts/'
ETT_LEDGER = '/api/ett/v3/accounts/'
ETT_ORDER = '/api/ett/v3/orders'
ETT_REVOKE = '/api/ett/v3/orders/'
ETT_ORDER_LIST = '/api/ett/v3/orders'
ETT_SPECIFIC_ORDER = '/api/ett/v3/orders/'
ETT_CONSTITUENTS = '/api/ett/v3/constituents/'
ETT_DEFINE = '/api/ett/v3/define-price/'

# SWAP
SWAP_POSITIONS = '/api/swap/v3/position'
SWAP_POSITION = '/api/swap/v3/'
SWAP_ACCOUNTS = '/api/swap/v3/accounts'
SWAP_ACCOUNT = '/api/swap/v3/'
SWAP_ORDER = '/api/swap/v3/order'
SWAP_ORDERS = '/api/swap/v3/orders'
SWAP_CANCEL_ORDER = '/api/swap/v3/cancel_order/'
SWAP_CANCEL_ORDERS = '/api/swap/v3/cancel_batch_orders/'
SWAP_FILLS = '/api/swap/v3/fills'
SWAP_INSTRUMENTS = '/api/swap/v3/instruments'
SWAP_TICKETS = '/api/swap/v3/instruments/ticker'
SWAP_RATE = '/api/swap/v3/rate'
