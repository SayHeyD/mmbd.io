import {expect, test} from '@playwright/test';
import common from './common';

test('How it works page loads', async ({ page, context }) => {
    await page.goto(`${common.appUrl}/how-it-works`);
    await expect(page.getByText('How it works')).toBeVisible()
});

test('Go back button works', async ({ page, context }) => {
    await page.goto(`${common.appUrl}/how-it-works`);
    await expect(page.getByText('How it works')).toBeVisible()

    await expect(page.getByRole('link', { name: 'Go back' })).toBeVisible();
    await page.getByTestId('go-back-button').click();

    await page.waitForURL('**/', {
        waitUntil: 'domcontentloaded',
    });
    await expect(page.getByRole('heading', { name: 'mmbd.io' })).toBeVisible();
});
