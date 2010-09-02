# encoding: utf-8


# =============================================================================
# package info
# =============================================================================
NAME = 'symmetrics_module_setmeta_perproduct'

TAGS = ('php', 'magento', 'symmetrics', 'module', 'meta', 'product', 'mrg')

LICENSE = 'AFL 3.0'

HOMEPAGE = 'http://www.symmetrics.de'

INSTALL_PATH = ''


# =============================================================================
# responsibilities
# =============================================================================
TEAM_LEADER = {
    'Torsten Walluhn': 'tw@symmetrics.de',
}

MAINTAINER = {
    'Eric Reiche': 'er@symmetrics.de',
}

AUTHORS = {
    'Eric Reiche': 'er@symmetrics.de',
    'Torsten Walluhn': 'tw@symmetrics.de',
}

# =============================================================================
# additional infos
# =============================================================================
INFO = 'Meta Informationen mit Produkt-Info füllen'

SUMMARY = '''
    Dieses Modul füllt die Meta Informationen eines Produktes mit
    den Kategorienamen und dem Produktnamen füllen.
'''

NOTES = '''
'''

# =============================================================================
# relations
# =============================================================================
REQUIRES = [
    {'magento': '*', 'magento_enterprise': '*'},
]

EXCLUDES = {}

VIRTUAL = {}

DEPENDS_ON_FILES = ()

PEAR_KEY = ''

COMPATIBLE_WITH = {
    'magento': ['1.4.0.0', '1.4.0.1', '1.4.1.1'],
    'magento_enterprise': ['1.7.0.0', '1.7.1.0', '1.8.0.0', '1.9.0.0'],
}
